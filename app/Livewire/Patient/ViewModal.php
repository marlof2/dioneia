<?php

namespace App\Livewire\Patient;

use App\Livewire\Traits\Alert;
use App\Models\Patient;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class ViewModal extends Component
{
    use Interactions, Alert;

    public Patient $patient;
    public $modal = false;
    public $title = 'Visualizar Paciente';
    public $currentStep = "1";

    public $optionsGender = [
        ['label' => 'Masculino', 'value' => 'Masculino'],
        ['label' => 'Homem Cisgênero', 'value' => 'Homem Cisgênero'],
        ['label' => 'Mulher Cisgênero', 'value' => 'Mulher Cisgênero'],
        ['label' => 'Homem Transgênero', 'value' => 'Homem Transgênero'],
        ['label' => 'Mulher Transgênero', 'value' => 'Mulher Transgênero'],
        ['label' => 'Pessoa Não Binária', 'value' => 'Pessoa Não Binária'],
        ['label' => 'Prefere não informar', 'value' => 'Prefere não informar'],
        ['label' => 'Outro', 'value' => 'Outro'],
    ];

    public $optionsMaritalStatus = [
        ['label' => 'Casado', 'value' => 'Casado'],
        ['label' => 'Solteiro', 'value' => 'Solteiro'],
        ['label' => 'Divorciado', 'value' => 'Divorciado'],
        ['label' => 'Viúvo', 'value' => 'Viúvo'],
    ];

    public $optionsEducationLevel = [
        ['label' => 'Ensino Fundamental', 'value' => 'Ensino Fundamental'],
        ['label' => 'Ensino Médio', 'value' => 'Ensino Médio'],
        ['label' => 'Ensino Superior', 'value' => 'Ensino Superior'],
        ['label' => 'Pós-Graduação', 'value' => 'Pós-Graduação'],
        ['label' => 'Mestrado', 'value' => 'Mestrado'],
        ['label' => 'Doutorado', 'value' => 'Doutorado'],
    ];

    public function render()
    {
        return view('livewire.patient.view-modal');
    }

    public function mount()
    {
        $this->patient = new Patient();
    }

    #[On('open-modal::patient-view')]
    public function openModal($id)
    {
        $this->modal = true;
        $this->patient = Patient::find($id);

    }
}
