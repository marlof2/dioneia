<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Carbon\Carbon;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?int $quantity = 10;
    public ?string $search = null;
    public bool $show = false;
    public ?Patient $patient = null;


    public array $sort = [
        'column'    => 'created_at',
        'direction' => 'desc',
    ];

    public array $headers = [
        ['index' => 'actions', 'label' => 'Ações',  'sortable' => false],
        ['index' => 'name', 'label' => 'Nome',  'sortable' => false],
        ['index' => 'birth_date', 'label' => 'Data de nascimento',  'sortable' => false],
        ['index' => 'age', 'label' => 'Idade',  'sortable' => false],
        ['index' => 'gender', 'label' => 'Gênero', 'sortable' => false],
    ];

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
}
