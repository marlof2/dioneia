<?php

namespace App\Livewire\Promptuary;

use App\Livewire\Forms\PromptuaryForm;
use App\Livewire\Traits\Alert;
use App\Models\Patient;
use App\Models\Promptuary;
use Livewire\Attributes\On;
use Livewire\Component;
use TallStackUi\Traits\Interactions;

class Create extends Component
{

    use Interactions, Alert;

    public PromptuaryForm $form;
    public $modal = false;
    public $title = 'Novo Prontuário';
    public $isEdit = false;
    public $itemsPatient;
    public $optionsType = [
        ['label' => 'Individual', 'value' => 'Individual'],
        ['label' => 'Casal', 'value' => 'Casal'],
    ];
    public $errors = [];

    public function mount()
    {
        $this->itemsPatient = Patient::all();
    }


    public function save()
    {
        try {
            $this->form->validate();

            $data = $this->form->all();

            if ($this->isEdit) {
                $promptuary = Promptuary::findOrFail($this->form->id);
                $promptuary->update($data);
                $this->isEdit = false;
            } else {
                unset($data['id']);
                Promptuary::create($data);
            }

            $this->modal = false;
            $this->form->reset();
            $this->dispatch('refresh');
            $this->toast()->success('Sucesso', 'Prontuário salvo com sucesso!')->send();
        } catch (\Illuminate\Validation\ValidationException $e) {
            $this->errors = $e->errors();
        } catch (\Exception $e) {
            $this->errors = ['error' => ['Ocorreu um erro ao salvar o prontuário: ' . $e->getMessage()]];
        }
    }

    #[On('open-modal::promptuary-form')]
    public function openModalPromptuaryForm($id)
    {
        if (isset($id)) {
            $this->isEdit = true;
            $this->setFormData($id);
        } else {
            $this->isEdit = false;
            $this->form->reset();
        }
        $this->modal = true;
    }

    public function setFormData($id)
    {
        $promptuary = Promptuary::findOrFail($id);
        $this->form->fill($promptuary->toArray());
    }


    public function changeType($value)
    {
        $this->form->type = $value;
    }

    public function render()
    {
        return view('livewire.promptuary.form');
    }
}
