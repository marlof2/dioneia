<?php

namespace App\Livewire\Patient;

use App\Livewire\Forms\ClinicalSituationForm;
use App\Livewire\Traits\Alert;
use App\Models\ClinicalSituation;
use Illuminate\Support\Collection;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class ClinicalSituationCreate extends Component
{
    use Interactions, Alert;

    public ClinicalSituationForm $form;
    public Collection $rows;
    public string $title = 'Situação Clínica';
    public bool $modal = false;
    public bool $isEdit = false;
    public bool $successMessage = false;
    public array $headers = [
        ['index' => 'actions', 'label' => 'Ações',  'sortable' => false],
        ['index' => 'doctor', 'label' => 'Médico',  'sortable' => false],
        ['index' => 'medication', 'label' => 'Medicamentação',  'sortable' => false],
    ];

    public function mount()
    {
        $this->rows = collect();
    }

    public function render()
    {
        return view('livewire.patient.clinical-situation');
    }


    public function setFormData($id)
    {
        $clinicalSituation = ClinicalSituation::findOrFail($id);
        $this->isEdit = true;
        $this->form->fill($clinicalSituation->toArray());
    }

    public function save()
    {
        try {
            $this->form->validate();

            if ($this->isEdit) {
                $clinicalSituation = ClinicalSituation::findOrFail($this->form->id);
                $clinicalSituation->update($this->form->except('patient_id', 'id'));
                $this->isEdit = false;
            } else {
                ClinicalSituation::create($this->form->all());
            }

            $this->rows = ClinicalSituation::where('patient_id', $this->form->patient_id)->get();
            $this->form->reset(['doctor', 'medication']);
            $this->successMessage = true;
            $this->toast()->success('Sucesso', 'Situação clínica salva com sucesso!')->send();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->flatten()->implode('<br>');
            $this->warning('Atenção!', $errors);
        } catch (\Exception $e) {
            $this->warning('Atenção!', 'Ocorreu um erro ao salvar a situação clínica: ' . $e->getMessage());
        }
    }

    #[On('open-modal::clinical-situation')]
    public function openClinicalSituationModal($id)
    {
        $this->form->patient_id = $id;
        $this->rows = ClinicalSituation::where('patient_id', $id)->get();
        $this->modal = true;
    }

    #[On('delete::clinical-situation')]
    public function destroy($id)
    {
        try {

            $clinicalSituation = ClinicalSituation::findOrFail($id);
            $clinicalSituation->delete();
            $this->rows = ClinicalSituation::where('patient_id', $this->form->patient_id)->get();
            $this->toast()->success('Sucesso', 'Situação clínica excluída com sucesso!')->send();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = collect($e->errors())->flatten()->implode('<br>');
            $this->warning('Atenção!', $errors);
        } catch (\Exception $e) {
            $this->warning('Atenção!', 'Ocorreu um erro ao excluir a situação clínica: ' . $e->getMessage());
        }
    }
}
