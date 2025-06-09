<?php

namespace App\Livewire\SessionReport;

use App\Livewire\Forms\SessionReportForm;
use App\Livewire\Traits\Alert;
use App\Models\Promptuary;
use App\Models\SessionReport;
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

    public $promptuary_id;
    public $quantity = 10;
    public $search = null;
    public $showPatientInfo = true;
    public Promptuary $promptuary;
    public SessionReportForm $form;
    public $isEdit = false;
    public $modal = false;
    public SessionReport $sessionReport;
    public array $headers = [
        ['index' => 'actions', 'label' => 'Ações', 'sortable' => false],
        ['index' => 'promptuary.patient1.name', 'label' => 'Paciente'],
        ['index' => 'created_at', 'label' => 'Data de Criação'],
    ];


    public function mount($promptuary_id)
    {
        $this->promptuary_id = $promptuary_id;
        $this->promptuary = Promptuary::with(['patient1', 'patient2'])->findOrFail($promptuary_id);
        if ($this->promptuary->type == 'Casal') {
            unset($this->headers[2]);
            $this->headers[1] = ['index' => 'promptuary.patient1.name', 'label' => 'Paciente 1'];
            $this->headers[2] = ['index' => 'promptuary.patient2.name', 'label' => 'Paciente 2'];
            $this->headers[3] =  ['index' => 'created_at', 'label' => 'Data de Criação'];
        }
    }

    public function render()
    {
        return view('livewire.session-report.index');
    }

    #[Computed()]
    public function itensTable(): LengthAwarePaginator
    {
        return SessionReport::where('promptuary_id', $this->promptuary_id)
            ->when($this->search, fn($query) => $query->where('created_at', 'like', '%' . $this->search . '%'))
            ->orderByDesc('created_at')
            ->paginate($this->quantity)
            ->withQueryString();
    }

    public function dateFormatted($date)
    {
        return Carbon::parse($date)->format('d/m/Y H:i');
    }

    public function togglePatientInfo()
    {
        $this->showPatientInfo = !$this->showPatientInfo;
    }

    #[On('open-modal::session-report-form')]
    public function openModal($id = null)
    {
        if ($id) {
            $this->isEdit = true;
            $this->form->id = $id;
            $sessionReport = SessionReport::findOrFail($id);
            $this->form->text = $sessionReport->text;
        } else {
            $this->isEdit = false;
            $this->form->reset();
        }
        $this->modal = true;
    }

    public function closeModal()
    {
        $this->modal = false;
        $this->form->reset();
    }

    public function save()
    {
        try {
            $this->form->validate();
            $data = $this->form->all();

            if ($this->isEdit) {
                $sessionReport = SessionReport::findOrFail($this->form->id);
                $sessionReport->update($data);
            } else {
                $data['promptuary_id'] = $this->promptuary_id;
                SessionReport::create($data);
            }

            $this->closeModal();
            $this->toast()->success('Sucesso', 'Relato de sessão salvo com sucesso!')->send();
        } catch (\Exception $e) {
            $this->toast()->error('Erro', 'Erro ao salvar relato de sessão: ' . $e->getMessage())->send();
        }
    }

    #[On('open-modal::session-report-delete')]
    public function openDeleteModal(SessionReport $sessionReport)
    {
        $this->sessionReport = $sessionReport;
        $this->question('Atenção!', 'Esta ação não poderá ser desfeita. Tem certeza que deseja excluir o relato de sessão ?')
            ->confirm(method: 'confirmDelete')
            ->cancel()
            ->send();
    }

    public function confirmDelete()
    {
        $this->sessionReport->delete();
        $this->toast()->success('Sucesso', 'Relato de sessão excluído com sucesso!')->send();
        // $this->dispatch('refresh');
    }
}
