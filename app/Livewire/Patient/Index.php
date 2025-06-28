<?php

namespace App\Livewire\Patient;

use App\Livewire\Traits\Alert;
use App\Livewire\Traits\WhatsAppTrait;
use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

class Index extends Component
{
    use WithPagination, Interactions, Alert, WhatsAppTrait;

    public ?int $quantity = 10;
    public ?string $search = null;
    public ?Patient $patient = null;
    public $title;

    public array $headers = [
        ['index' => 'actions', 'label' => 'Ações',  'sortable' => false],
        ['index' => 'name', 'label' => 'Nome',  'sortable' => false],
        ['index' => 'birth_date', 'label' => 'Data de nascimento',  'sortable' => false],
        ['index' => 'age', 'label' => 'Idade',  'sortable' => false],
        ['index' => 'gender', 'label' => 'Gênero', 'sortable' => false],
        ['index' => 'created_at', 'label' => 'Data inclusão', 'sortable' => false],
    ];


    public function mount()
    {
        $this->title = 'Pacientes';
    }

    public function render()
    {
        return view('livewire.patient.index');
    }

    #[Computed()]
    public function patients(): LengthAwarePaginator
    {
        return Patient::with('documents', 'clinicalSituations')
            ->when($this->search, fn($query) => $query->where('name', 'like', '%' . $this->search . '%'))
            ->orderBy('name', 'asc')
            ->paginate($this->quantity)
            ->withQueryString();
    }

    public function dateFormatted($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function isBirthday($date)
    {
        return Carbon::parse($date)->isBirthday();
    }

    public function navigateToEdit($id)
    {
        return $this->redirect('/patients/edit/' . $id, navigate: true);
    }

    public function navigateToCreate()
    {
        return $this->redirect('/patients/create', navigate: true);
    }

    #[On('patient-delete')]
    public function openDeleteModal($id)
    {
        $this->patient = Patient::find($id);
        $this->question('Atenção!', 'Esta ação não poderá ser desfeita. Tem certeza que deseja excluir o paciente ' . $this->patient->name . '?')
            ->confirm(method: 'confirmDelete')
            ->cancel()
            ->send();
    }

    public function confirmDelete()
    {
        $this->patient->delete();
        $this->toast()->success('Sucesso', 'Paciente excluído com sucesso!')->send();
        return $this->redirect('/patients', navigate: true);
    }

}
