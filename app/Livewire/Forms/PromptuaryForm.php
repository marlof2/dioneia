<?php

namespace App\Livewire\Forms;

use App\Models\Promptuary;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PromptuaryForm extends Form
{
    public $id;
    public $type;
    public $patient1_id;
    public $patient2_id;

    public function rules()
    {
        return [
            'type' => 'required|string',
            'patient1_id' => 'required',
            'patient2_id' => 'required_if:type,Casal',
        ];
    }

    public function messages()
    {
        return [
            'type.required' => 'O tipo é obrigatório',
            'patient1_id.required' => 'O paciente 1 é obrigatório',
            'patient2_id.required_if' => 'O paciente 2 é obrigatório para tipo Casal',
        ];
    }

}
