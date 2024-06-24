<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'string'],
            'code' => ['required', 'min:0', 'integer'],
            'order' => ['nullable', 'min:0', 'integer'],
            'game_type_id' => ['required', 'array'],
            'image' => ['required', 'image'],
            'rate' => ['required'],
        ];
    }
}
