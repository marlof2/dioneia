<?php

namespace App\Livewire\Patient;

use App\Models\Patient;
use Illuminate\Pagination\LengthAwarePaginator;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    public ?int $quantity = 10;
    public ?string $search = null;
    public bool $show = false;
    public ?Patient $patient = null;


    public array $sort = [
        'column'    => 'created_at',
        'direction' => 'desc',
    ];

    public array $headers = [
        ['index' => 'actions', 'label' => 'Ações'],
        ['index' => 'name', 'label' => 'Nome'],
        ['index' => 'birth_date', 'label' => 'Data de nascimento'],
        ['index' => 'age', 'label' => 'Idade'],
        ['index' => 'gender', 'label' => 'Gênero'],
    ];

    public function render()
    {
        return view('livewire.patient.index');
    }

    #[Computed()]
    public function patients(): LengthAwarePaginator
    {
        return Patient::with('contacts', 'documents', 'clinicalSituations')
        ->when($this->search !== null, fn ($query) => $query->whereAny(['name', 'email'], 'like', '%'.trim($this->search).'%'))
        ->orderBy(...array_values($this->sort))
        ->paginate($this->quantity)
        ->withQueryString();
    }

    public function loadPatient($id)
    {
        $this->patient = Patient::find($id);
        dd($this->patient);
    }

    public function navigateToCreate()
    {
        return $this->redirect('/patients/create', navigate: true);
    }
}
