<?php

namespace App\Livewire\Forms;

use App\Models\Patient;
use App\Models\Promptuary;
use Livewire\Attributes\Validate;
use Livewire\Form;

class PromptuaryForm extends Form
{
    public $id;
    public $type = 'Individual';
    public $patient1_id;
    public $patient2_id;

    public function rules()
    {
        return [
            'type' => 'required|string',
            'patient1_id' => [
                'required',
                function ($attribute, $value, $fail) {
                    if ($this->type === 'Individual') {
                        $exists = Promptuary::where('patient1_id', $value)
                            ->exists();

                        $patient = Patient::find($value);
                        if ($exists) {
                            $fail('O paciente ' . $patient->name . ' já está cadastrado em um prontuário do tipo individual');
                        }
                    }
                },
            ],
            'patient2_id' => [
                'required_if:type,Casal',
                function ($attribute, $value, $fail) {
                    if ($this->type === 'Casal') {
                        $exists = Promptuary::orWhere('patient2_id', $value)
                            ->orWhere('patient1_id', $value)
                            ->exists();

                        $patient1 = Patient::find($this->patient1_id);
                        $patient2 = Patient::find($value);

                        if ($exists) {
                            $fail('O paciente ' . $patient1->name . ' já está cadastrado em um prontuário do tipo casal com o paciente ' . $patient2->name);
                        }
                    }
                },
            ],
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
