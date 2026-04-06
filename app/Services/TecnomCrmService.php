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
        $xmlBody = $this->generateAdfXml($leadData);

        try {
            $response = Http::withBasicAuth($this->user, $this->pass)
                ->withHeaders([
                    'Content-Type' => 'application/x-www-form-urlencoded'
                ])
                ->asForm()
                ->post($this->endpoint, [
                    'data' => $xmlBody
                ]);

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
     * Generar el string XML en formato ADF 1.0.
     *
     * @param array $data
     * @return string
     */
    protected function generateAdfXml(array $data): string
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

        return <<<XML
<?xml version="1.0" encoding="UTF-8"?>
<?adf version="1.0"?>
<adf>
    <prospect>
        <requestdate>{$date}</requestdate>
        <vehicle interest="buy" status="new">
            <year>{$year}</year>
            <make>{$brand}</make>
            <model>{$model}</model>
            <trim>{$version}</trim>
        </vehicle>
        <customer>
            <contact>
                <name part="first">{$firstName}</name>
                <name part="last">{$lastName}</name>
                <email>{$email}</email>
                <phone type="cell">{$phone}</phone>
            </contact>
            <comments>Origen: {$source} | Mensaje: {$message}</comments>
        </customer>
        <vendor>
            <vendorname>Automotriz Carmona</vendorname>
        </vendor>
        <provider>
            <name>Sitio Web Automotriz Carmona</name>
        </provider>
    </prospect>
</adf>
XML;
    }
}
