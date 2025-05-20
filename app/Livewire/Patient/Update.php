<?php

namespace App\Livewire\Patient;

use App\Livewire\Forms\PatientForm;
use App\Livewire\Traits\Alert;
use App\Models\Patient;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Update extends Component
{
    use Interactions, Alert;

    public Patient $patient;
    public PatientForm $form;
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
        return view('livewire.patient.form');
    }

    public function mount($id)
    {
        $this->patient = Patient::find($id);
        $this->form->fill($this->patient->toArray());
        $this->form->family_suicide_history = $this->form->family_suicide_history == 1 ? true : false;
        $this->form->suicidal_thoughts = $this->form->suicidal_thoughts == 1 ? true : false;
    }

    public function calculateAge()
    {
        if ($this->form->birth_date) {
            $birthDate = \Carbon\Carbon::parse($this->form->birth_date);
            $this->form->age = $birthDate->age;
        }
    }

    public function save()
    {
        try {
            $this->validate();
            $this->patient->update($this->form->all());

            $this->toast()->success('Sucesso', 'Paciente atualizado com sucesso!')->send();
            return $this->redirect('/patients', navigate: true);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->flatten()->implode('<br>');
            $this->warning('Atenção!', $errors);
        } catch (\Exception $e) {
            $this->warning('Atenção!', 'Ocorreu um erro ao atualizar o paciente: ' . $e->getMessage());
        }
    }
}
