<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'string|max:255',
            'price' => 'numeric|min:0',
            'duration' => 'integer|min:1',
            'highlight' => 'boolean',
            'type' => 'string|in:professional,client',
            'coins' => 'integer|min:0',
            'benefits' => 'array',
            'benefits.*' => 'string|max:255',
        ];
    }
}
