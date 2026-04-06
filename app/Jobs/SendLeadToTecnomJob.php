<?php

namespace App\Jobs;

use App\Models\Lead;
use App\Services\TecnomCrmService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class SendLeadToTecnomJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected Lead $lead, protected array $sourceData)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(TecnomCrmService $crmService): void
    {
        Log::info("Enviando lead ID: {$this->lead->id} a Tecnom CRM en cola...");

        $success = $crmService->sendLead($this->sourceData);

        if ($success) {
            $this->lead->update(['crm_synced' => true]);
        } else {
            Log::error("Falla en el envío de lead ID: {$this->lead->id} a Tecnom CRM.");
            // Opcionalmente reintentar
        }
    }
}
