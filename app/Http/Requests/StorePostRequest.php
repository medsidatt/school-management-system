<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            'p_first_name' => 'required',
            'p_last_name' => 'required',
            'p_sex' => 'required',
            'p_tel' => "required|unique:parents,tel,$this->p_id|digits:8|numeric",
            'p_date_of_birth' => 'required|date|before_or_equal:' . now()->subYears(18)->format('Y-m-d') . '|after_or_equal:' . now()->subYears(100)->format('Y-m-d'),
            'p_nni' => "required|numeric|digits:10|unique:parents,tel,$this->p_id",

            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'class' => 'required',
            'date_of_birth' => 'required|date|before_or_equal:' . now()->subYears(13)->format('Y-m-d') . '|after_or_equal:' . now()->subYears(23)->format('Y-m-d'),
            'rim' => "required|unique:students,rim,$this->id|numeric|digits:7",
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
            // student
            'first_name' => 'prenom',
            'last_name' => 'nom',
            'sex' => 'sexe',
            'class' => 'classe',
            'date_of_birth' => 'date de naissance',

            //parent
            'p_first_name' => 'prenom',
            'p_last_name' => 'nom',
            'p_sex' => 'sexe',
            'p_tel' => 'tel',
            'p_date_of_birth' => 'date de naissance',
            'p_nni' => 'nni'
        ];
    }


}
