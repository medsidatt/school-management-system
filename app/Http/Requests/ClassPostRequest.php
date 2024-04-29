<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClassPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|unique:classes,name,5'
        ];
    }

    public function messages(): array
    {
        return [
            'required' => 'L\'attribut :attribute est obligatoire'
        ];
    }

    public function attributes(): array
    {
        return [
            'name' => 'labele'
        ];
    }
}
