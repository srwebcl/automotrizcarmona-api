<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Http\JsonResponse;

class CarAdvisorController extends Controller
{
    private const CACHE_KEY = 'caradvisor_data';
    private const CACHE_TTL = 86400; // 24 horas en segundos

    /**
     * Retorna las reseñas y resumen del dealer desde Car Advisor (Porsche Informatik).
     * Los datos se cachean por 24 horas para no sobrecargar la API externa.
     */
    public function summary(): JsonResponse
    {
        try {
            $data = Cache::remember(self::CACHE_KEY, self::CACHE_TTL, function () {
                return $this->fetchFromApi();
            });

            if ($data === null) {
                return response()->json(['error' => 'No se pudo obtener datos de Car Advisor.'], 503);
            }

            return response()->json($this->processData($data));

        } catch (\Throwable $e) {
            \Log::error('CarAdvisor API error: ' . $e->getMessage());
            return response()->json(['error' => 'Error al consultar reseñas.'], 500);
        }
    }

    /**
     * Fuerza la actualización del caché (para uso interno o schedule).
     */
    public function refresh(): JsonResponse
    {
        Cache::forget(self::CACHE_KEY);
        $data = $this->fetchFromApi();

        if ($data === null) {
            return response()->json(['error' => 'No se pudo refrescar el caché.'], 503);
        }

        Cache::put(self::CACHE_KEY, $data, self::CACHE_TTL);
        return response()->json(['message' => 'Caché de Car Advisor actualizado correctamente.', 'ratings_count' => count($data['ratings'] ?? [])]);
    }

    /**
     * Realiza la petición HTTP a la API de Porsche Informatik.
     */
    private function fetchFromApi(): ?array
    {
        $dealerId = config('services.caradvisor.dealer_id', env('CARADVISOR_DEALER_ID', '29019'));
        $apiKey   = config('services.caradvisor.api_key', env('CARADVISOR_API_KEY'));
        $user     = config('services.caradvisor.user', env('CARADVISOR_USER', 'CL'));
        $pass     = config('services.caradvisor.pass', env('CARADVISOR_PASS'));

        $response = Http::timeout(15)
            ->withHeaders(['X-API-Key' => $apiKey])
            ->withBasicAuth($user, $pass)
            ->get("https://api.porscheinformatik.com/apiman-gateway/Caradvisor/dealer_summary_CL/1.0/{$dealerId}");

        if (!$response->successful()) {
            \Log::error('CarAdvisor API failed: HTTP ' . $response->status(), ['body' => $response->body()]);
            return null;
        }

        return $response->json();
    }

    /**
     * Procesa y limpia el payload de la API para consumo del frontend.
     * Ordena por fecha descendente y filtra reseñas con texto.
     */
    private function processData(array $data): array
    {
        $ratings = collect($data['ratings'] ?? [])
            ->filter(fn($r) => !empty($r['ratingText']) && ($r['rating'] ?? 0) >= 3)
            ->sortByDesc('ratingDate')
            ->take(20)
            ->values()
            ->map(fn($r) => [
                'userName'    => $r['userName'] ?? 'Cliente',
                'title'       => $r['title'] ?? '',
                'text'        => $r['ratingText'] ?? '',
                'rating'      => (int) ($r['rating'] ?? 5),
                'recommended' => (bool) ($r['recommended'] ?? true),
                'date'        => $r['ratingDate'] ?? null,
                'reason'      => $r['reason'] ?? [],
                'brand'       => $r['brand'] ?? null,
            ])
            ->toArray();

        return [
            'overallRating'        => round((float) ($data['overallRatingAvg'] ?? 0), 1),
            'recommendPercentage'  => (int) ($data['recommendPercentage'] ?? 0),
            'totalRatings'         => (int) ($data['nrOfRatings'] ?? 0),
            'dealerPage'           => $data['dealerPage'] ?? 'https://www.caradvisor.at/d/betrieb/carmona/CL-29019',
            'ratings'              => $ratings,
        ];
    }
}
