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
            'img_path' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'date_of_birth' => 'required|date|before_or_equal:' . now()->subYears(19)->format('Y-m-d') . '|after_or_equal:' . now()->subYears(80)->format('Y-m-d'),
            'nni' => "required|unique:teachers,nni,$this->id|numeric|digits:10",
        ];
    }

    public function messages(): array
    {
        return [
            'img_path.image' => 'Le champ :attribute doit être une image.!',
            'date_of_birth.before_or_equal' => 'L\'enseignant doit être âgé d\'au moin 13 ans.',
            'date_of_birth.after_or_equal' => 'L\'enseignant doit être âgé d\'au plus 23.',
            'required' => 'L\'attribut :attribute est obligatoire'
        ];
    }

    public function attributes(): array
    {
        return [
            'first_name' => 'prenom',
            'last_name' => 'nom',
            'sex' => 'sexe',
            'img_path' => 'image',
            'date_of_birth' => 'date de naissance',
            'nni' => 'nni'
        ];
    }
}
