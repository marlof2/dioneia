<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class ClinicalSituationForm extends Form
{
    public $id;
    public $patient_id;
    public $doctor;
    public $medication;

    public function rules()
    {
        return [
            'patient_id' => 'required',
            'doctor' => 'required',
            'medication' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'patient_id.required' => 'O paciente é obrigatório',
            'doctor.required' => 'O nome do médico é obrigatório',
            'medication.required' => 'A medicamentação é obrigatória',
        ];
    }
}
