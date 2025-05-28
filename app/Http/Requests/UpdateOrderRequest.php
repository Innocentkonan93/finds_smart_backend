<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
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
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'client_id' => 'exists:users,id',
            'professional_id' => 'exists:users,id',
            'service_id' => 'exists:services,id',
            'status' => 'in:pending,accepted,completed,canceled',
            'total_price' => 'numeric|min:0',
            'city' => 'string|max:255',
            'district' => 'string|max:255',
            'start_date' => 'date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
