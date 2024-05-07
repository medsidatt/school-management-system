<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TeacherPostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'date_of_birth' => 'required|date|before_or_equal:' . now()->subYears(19)->format('Y-m-d') . '|after_or_equal:' . now()->subYears(80)->format('Y-m-d'),
            'nni' => "required|unique:teachers,nni,$this->id|numeric|digits:10",
        ];
    }

    public function messages(): array
    {
        return [
            'date_of_birth.before_or_equal' => 'The student must be at most 13 years old.',
            'date_of_birth.after_or_equal' => 'The student must be at least 23 years old.',
            'required' => 'L\'attribut :attribute est obligatoire'
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'prenom',
            'last_name' => 'nom',
            'sex' => 'sexe',
//            'class' => 'classe',
            'date_of_birth' => 'date de naissance',
            'nni' => 'nni'
        ];
    }
}
