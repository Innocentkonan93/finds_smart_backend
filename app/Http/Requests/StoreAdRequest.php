<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'category_id' => 'required|exists:job_categories,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'budget' => 'nullable|numeric|min:0',
            'start_date' => 'nullable|date|after_or_equal:today',
            'city' => 'required|string|max:255',
            'district' => 'nullable|string|max:255',
            'status' => 'in:pending,accepted,completed,cancelled',
        ];
    }
}
