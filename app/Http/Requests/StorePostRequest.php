<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'p_first_name' => 'required',
            'p_last_name' => 'required',
            'p_sex' => 'required',
            'p_tel' => [
                'required',
                'unique:parents,tel,' . $this->p_id,
                'digits:8',
                'numeric',
                'regex:/^(?:2|3|4)\d{7}$/'
            ],
            'p_date_of_birth' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(18)->format('Y-m-d'),
                'after_or_equal:' . now()->subYears(100)->format('Y-m-d')
            ],

            'p_nni' => [
                'required',
                'numeric',
                'digits:10',
                "unique:parents,nni,$this->p_id"
            ],

            'first_name' => 'required',
            'last_name' => 'required',
            'sex' => 'required',
            'class' => 'required',
            'date_of_birth' => [
                'required',
                'date',
                'before_or_equal:' . now()->subYears(13)->format('Y-m-d'),
                'after_or_equal:' . now()->subYears(23)->format('Y-m-d')
            ],
            'rim' => "required|unique:students,rim,$this->id|numeric|digits:7",
        ];
    }

//    public function withValidator($validator)
//    {
//        $validator->after(function ($validator) {
//            if ($this->request->get('p_nni') % 97 !== 1) {
//                $validator->errors()->add('p_nni', 'Le nni est invalide');
//            }
//        });
//    }
    public function messages(): array
    {
        return [
            'p_tel.regex' => 'Le numero telefone doit comence par 2, 3 ou 4',
            'date_of_birth.before_or_equal' => 'L\'étudiant doit être âgé d\'au moin 13 ans.',
            'date_of_birth.after_or_equal' => 'L\'étudiant doit être âgé d\'au plus 23 ans.',
            'p_date_of_birth.before_or_equal' => 'Le parent doit être âgé d\'au moin 25 ans.',
            'p_date_of_birth.after_or_equal' => 'Le parent doit être âgé d\'au plus 100 ans.',
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
