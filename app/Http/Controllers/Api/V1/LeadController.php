<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\LeadStoreRequest;
use App\Models\Lead;
use App\Jobs\SendLeadToTecnomJob;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;

class LeadController extends Controller
{
    /**
     * Store a newly created lead in storage.
     */
    public function store(LeadStoreRequest $request): JsonResponse
    {
        $validated = $request->validated();
        
        $customerData = $validated['customer'] ?? [];
        $fullName = ($customerData['first_name'] ?? '') . ' ' . ($customerData['last_name'] ?? '');

        // 1. Guardar en base de datos local
        $lead = Lead::create([
            'source' => $validated['source'],
            'rut' => $customerData['rut'] ?? null,
            'name' => trim($fullName),
            'email' => $customerData['email'] ?? '',
            'phone' => $customerData['phone'] ?? '',
            'company' => $customerData['company'] ?? null,
            'vehicle_id' => $validated['vehicle']['model_name'] ?? null,
            'service_type' => $validated['request_details']['service_type'] ?? null,
            'message' => $validated['request_details']['message'] ?? '',
            'raw_request' => $validated, // Guardamos los datos validados como JSON
            'crm_synced' => false,
        ]);

        $directForms = ['contacto', 'reclamos', 'dyp'];

        if (in_array(strtolower($lead->source), $directForms)) {
            // Obtenemos correos desde la Base de Datos
            $recipientConfig = \App\Models\FormRecipient::where('identifier', strtolower($lead->source))->first();
            
            if ($recipientConfig && !empty($recipientConfig->emails)) {
                $emails = $recipientConfig->emails;
                \Illuminate\Support\Facades\Mail::to($emails)->send(new \App\Mail\ContactFormMail($lead));
            }
        } else {
            // 2. Despachar Job para enviar al CRM (Background)
            SendLeadToTecnomJob::dispatch($lead, $validated);
        }

        Log::info("Lead recibido y procesado correctamente: id={$lead->id}");

        return response()->json([
            'status' => 'success',
            'message' => 'Lead recibido correctamente y encolado para sincronización.',
            'data' => [
                'lead_id' => $lead->id
            ]
        ], 201);
    }
}
