<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class LeadStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'source' => 'required|string|in:ventas,dyp,servicio_tecnico,repuestos,reclamos,contacto',
            'customer' => 'required|array',
            'customer.rut' => 'nullable|string',
            'customer.first_name' => 'required|string|max:255',
            'customer.last_name' => 'required|string|max:255',
            'customer.email' => 'required|email|max:255',
            'customer.phone' => 'required|string|max:20',
            'vehicle' => 'nullable|array',
            'vehicle.brand_name' => 'nullable|string',
            'vehicle.model_name' => 'nullable|string',
            'vehicle.version_name' => 'nullable|string',
            'vehicle.year' => 'nullable|string',
            'vehicle.vin' => 'nullable|string',
            'request_details' => 'nullable|array',
            'request_details.service_type' => 'nullable|string',
            'request_details.message' => 'nullable|string'
        ];
    }
}
