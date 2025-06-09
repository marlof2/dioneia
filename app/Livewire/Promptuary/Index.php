<?php

namespace App\Livewire\Promptuary;

use App\Livewire\Traits\Alert;
use App\Models\Promptuary;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use TallStackUi\Traits\Interactions;

class Index extends Component
{
    use WithPagination, Interactions, Alert;
    public string $title = 'Prontuário';
    public ?int $quantity = 10;
    public ?string $patientName1 = null;
    public ?string $patientName2 = null;
    public ?string $type = null;
    public ?Promptuary $promptuary = null;

    public array $headers = [
        ['index' => 'actions', 'label' => 'Ações', 'sortable' => false],
        ['index' => 'id', 'label' => 'Identificador'],
        ['index' => 'type', 'label' => 'Tipo'],
        ['index' => 'patient1.name', 'label' => 'Paciente 1'],
        ['index' => 'patient2.name', 'label' => 'Paciente 2'],
        ['index' => 'created_at', 'label' => 'Data de inclusão'],
    ];


    #[Computed()]
    public function itensTable(): LengthAwarePaginator
    {
        return Promptuary::with('patient1', 'patient2')
            ->when($this->patientName1, fn($query) => $query->whereRelation('patient1', 'name', 'like', '%' . $this->patientName1 . '%'))
            ->when($this->patientName2, fn($query) => $query->whereRelation('patient2', 'name', 'like', '%' . $this->patientName2 . '%'))
            ->when($this->type, fn($query) => $query->where('type', $this->type))
            ->orderByDesc('created_at')
            ->paginate($this->quantity)
            ->withQueryString();
    }

    public function dateFormatted($date)
    {
        return Carbon::parse($date)->format('d/m/Y');
    }

    public function render()
    {
        return view('livewire.promptuary.index');
    }

    #[On('open-modal::promptuary-delete')]
    public function openDeleteModal(Promptuary $promptuary)
    {
        $this->promptuary = $promptuary;
        $this->question('Atenção!', 'Esta ação não poderá ser desfeita. Tem certeza que deseja excluir o prontuário ?')
            ->confirm(method: 'confirmDelete')
            ->cancel()
            ->send();
    }

    public function confirmDelete()
    {
        $this->promptuary->delete();
        $this->toast()->success('Sucesso', 'Prontuário excluído com sucesso!')->send();
        $this->dispatch('refresh');
    }

    public function navigateToSessionReport($id)
    {
        return $this->redirect('/session-report/' . $id, navigate: true);
    }

    #[On('setDataFilter')]
    public function setDataFilter($data)
    {
        $this->patientName1 = $data['patientName1'] ?? null;
        $this->patientName2 = $data['patientName2'] ?? null;
        $this->type = $data['type'] ?? null;
    }
}
