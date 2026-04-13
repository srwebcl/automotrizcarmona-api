<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TecnomCrmService
{
    protected string $user;
    protected string $pass;
    protected string $endpoint;

    public function __construct()
    {
        $this->user = config('services.tecnom.user', env('TECNOM_USER', ''));
        $this->pass = config('services.tecnom.pass', env('TECNOM_PASS', ''));
        $this->endpoint = 'https://automotrizcarmona.tecnomcrm.com/api/v1/webconnector/consultas/adf';
    }

    /**
     * Enviar un lead a Tecnom CRM en formato ADF XML.
     *
     * @param array $leadData
     * @return bool
     */
    public function sendLead(array $leadData): bool
    {
        $payload = $this->generateAdfJson($leadData);

        try {
            $response = Http::withBasicAuth($this->user, $this->pass)
                ->withHeaders([
                    'Accept' => 'application/json',
                    'Content-Type' => 'application/json'
                ])
                ->post($this->endpoint, $payload);

            if ($response->successful()) {
                Log::info("Lead enviado exitosamente a Tecnom CRM", ['lead_id' => $leadData['id'] ?? 'unknown']);
                return true;
            }

            Log::error("Error al enviar lead a Tecnom CRM", [
                'status' => $response->status(),
                'body' => $response->body(),
                'lead_id' => $leadData['id'] ?? 'unknown'
            ]);

            return false;
        } catch (\Exception $e) {
            Log::error("Excepción al enviar lead a Tecnom CRM: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Generar la estructura JSON en formato ADF 1.0.
     *
     * @param array $data
     * @return array
     */
    protected function generateAdfJson(array $data): array
    {
        $date = now()->toIso8601String();
        $source = $data['source'] ?? 'Sitio Web';
        $firstName = $data['customer']['first_name'] ?? '';
        $lastName = $data['customer']['last_name'] ?? '';
        $email = $data['customer']['email'] ?? '';
        $phone = $data['customer']['phone'] ?? '';
        $message = $data['request_details']['message'] ?? '';
        
        $brand = $data['vehicle']['brand_name'] ?? '';
        $model = $data['vehicle']['model_name'] ?? '';
        $version = $data['vehicle']['version_name'] ?? '';
        $year = $data['vehicle']['year'] ?? '';
        $vin = $data['vehicle']['vin'] ?? '';
        
        // El año debe ser entero si existe, si no null
        $yearInt = is_numeric($year) ? (int) $year : null;
        
        $rut = $data['customer']['rut'] ?? '';
        $company = $data['customer']['company'] ?? '';

        $extraInfo = [];
        if (!empty($rut)) $extraInfo[] = "RUT: $rut";
        if (!empty($company)) $extraInfo[] = "Empresa: $company";
        if (!empty($vin)) $extraInfo[] = "VIN: $vin";
        
        $extraStr = !empty($extraInfo) ? ' | ' . implode(' | ', $extraInfo) : '';
        $fullComments = "Origen: {$source} | Mensaje: {$message}{$extraStr}";

        $prospect = [
            'requestdate' => $date,
            'customer' => [
                'comments' => $fullComments,
                'contacts' => [
                    [
                        'names' => [
                            [
                                'part' => 'first',
                                'value' => $firstName
                            ],
                            [
                                'part' => 'last',
                                'value' => $lastName
                            ]
                        ],
                    ]
                ]
            ],
            'provider' => [
                'name' => [
                    'value' => 'Sitio Web Automotriz Carmona'
                ],
                'service' => 'Integración Web'
            ]
        ];

        // Añadir email si existe
        if (!empty($email)) {
            $prospect['customer']['contacts'][0]['emails'] = [
                ['value' => $email]
            ];
        }

        // Añadir teléfono si existe
        if (!empty($phone)) {
            $prospect['customer']['contacts'][0]['phones'] = [
                ['type' => 'cellphone', 'value' => $phone]
            ];
        }

        // Añadir vehículo si hay datos
        if (!empty($brand) || !empty($model)) {
            $vehicle = [];
            if (!empty($brand)) $vehicle['make'] = $brand;
            if (!empty($model)) $vehicle['model'] = $model;
            if (!empty($version)) $vehicle['trim'] = $version;
            if ($yearInt !== null) $vehicle['year'] = $yearInt;
            
            $vehicle['interest'] = 'buy';
            $vehicle['status'] = 'new';
            
            $prospect['vehicles'] = [$vehicle];
        }

        return ['prospect' => $prospect];
    }
}
