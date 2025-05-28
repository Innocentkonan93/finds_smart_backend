<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'client_id' => 'required|exists:users,id',
            'service_id' => 'required|exists:services,id',
            'professional_id' => 'exists:users,id',
            'status' => 'required|in:pending,accepted,completed,canceled',
            'total_price' => 'required|numeric|min:0',
            'city' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'start_date' => 'required|date',
            'description' => 'nullable|string',
            'notes' => 'nullable|string',
        ];
    }
}
