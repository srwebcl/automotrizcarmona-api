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
            'vehicle_id' => isset($validated['vehicle']['model_name']) ? $validated['vehicle']['model_name'] : null,
            'service_type' => isset($validated['request_details']['service_type']) ? $validated['request_details']['service_type'] : null,
            'message' => isset($validated['request_details']['message']) ? $validated['request_details']['message'] : '',
            'raw_request' => $validated, // Guardamos los datos validados como JSON
            'crm_synced' => false,
        ]);

        $directForms = ['contacto', 'reclamos', 'dyp', 'promociones'];

        if (in_array(strtolower($lead->source), $directForms)) {
            // Aseguramos que exista el registro para que pueda ser gestionado desde "Emails Formularios" en Filament
            $recipientConfig = \App\Models\FormRecipient::firstOrCreate(
                ['identifier' => strtolower($lead->source)],
                [
                    'name' => 'Formulario: ' . ucfirst(strtolower($lead->source)), 
                    'emails' => ['contacto@carmonaycia.cl']
                ]
            );
            
            if ($recipientConfig && !empty($recipientConfig->emails)) {
                $emails = $recipientConfig->emails;
                try {
                    \Illuminate\Support\Facades\Mail::to($emails)->send(new \App\Mail\ContactFormMail($lead));
                } catch (\Throwable $e) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'MAIL_ERROR: ' . $e->getMessage() . ' en ' . $e->getFile() . ':' . $e->getLine()
                    ], 400); // 400 para q no devuelva 500
                }
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
