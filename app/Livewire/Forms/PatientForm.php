<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class PatientForm extends Form
{
    // Dados Pessoais
    public $name = null;
    public $birth_date = null;
    public $age = null;
    public $gender = null;
    public $marital_status =  null;
    public $children = 0;

    // Endereço e Contato
    public $address = null;
    public $city = null;
    public $phone = null;
    public $emergency_phone_1 = null;
    public $emergency_contact_1 = null;
    public $emergency_phone_2 = null;
    public $emergency_contact_2 = null;

    // Informações Adicionais
    public $religion = null;
    public $education_level = null;
    public $occupation = null;
    public $vices = null;
    public $family_suicide_history = false;
    public $suicidal_thoughts = false;
    public $disorders = null;



    protected  function rules()
    {
        return [
            // Dados Pessoais
            'name' => 'required',
            'birth_date' => 'required|date',
            'age' => 'required|numeric|min:0',
            'gender' => 'required',
            'marital_status' => 'required',
            'children' => 'required|numeric|min:0',

            // Endereço e Contato
            'address' => 'required',
            'city' => 'required',
            'phone' => 'required',
            'emergency_phone_1' => 'nullable',
            'emergency_contact_1' => 'nullable',
            'emergency_phone_2' => 'nullable',
            'emergency_contact_2' => 'nullable',

            // Informações Adicionais
            'religion' => 'nullable',
            'education_level' => 'required',
            'occupation' => 'required',
            'vices' => 'nullable',
            'family_suicide_history' => 'boolean',
            'suicidal_thoughts' => 'boolean',
            'disorders' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'O nome completo é obrigatório',
            'birth_date.required' => 'A data de nascimento é obrigatória',
            'birth_date.date' => 'A data de nascimento deve ser uma data válida',
            'age.required' => 'A idade é obrigatória',
            'age.numeric' => 'A idade deve ser um número',
            'gender.required' => 'O gênero é obrigatório',
            'marital_status.required' => 'O estado civil é obrigatório',
            'children.required' => 'O número de filhos é obrigatório',
            'children.numeric' => 'O número de filhos deve ser um número',
            'address.required' => 'O endereço é obrigatório',
            'city.required' => 'A cidade é obrigatória',
            'phone.required' => 'O telefone principal é obrigatório',
            'education_level.required' => 'O nível de escolaridade é obrigatório',
            'occupation.required' => 'A ocupação é obrigatória',
        ];
    }

}
