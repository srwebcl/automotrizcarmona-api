<?php

namespace App\Mail;

use App\Models\Lead;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

/**
 * Alerta enviada cuando un lead Toyota (source=ventas) no pudo sincronizarse
 * con Salesforce. Estos leads nunca se envían a Tecnom (ver LeadController),
 * así que este correo es la única vía de aviso para gestión manual.
 */
class SalesforceRejectedLeadMail extends Mailable
{
    use Queueable, SerializesModels;

    public Lead $lead;
    public ?string $reason;

    public function __construct(Lead $lead, ?string $reason = null)
    {
        $this->lead = $lead;
        $this->reason = $reason;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Lead Toyota no sincronizado con Salesforce — requiere gestión manual',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.salesforce-rejected',
            with: [
                'lead' => $this->lead,
                'reason' => $this->reason,
            ],
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
