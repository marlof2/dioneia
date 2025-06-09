<?php

namespace App\Livewire\Promptuary;

use Livewire\Component;

class Filter extends Component
{
    public $dataFilter = [
        'type' => null,
        'patientName1' => null,
        'patientName2' => null
    ];
    public $slide = false;
    public $optionsType = [
        ['label' => 'Individual', 'value' => 'Individual'],
        ['label' => 'Casal', 'value' => 'Casal'],
    ];

    public function render()
    {
        return <<<'HTML'
        <div>
            <x-button
                icon="magnifying-glass"
                text="Filtro"
                color="orange"
                wire:click="openFilterModal"
            />

            <x-slide wire left title="Campos de filtro">
                <x-slot:title>
                    <div class="flex items-center justify-center">
                        <h2 class="text-lg font-bold">Campos de filtro</h2>
                    </div>
                </x-slot:title>

                <x-card class="p-4">
                    <form wire:submit="setDataFilter" class="grid grid-cols-1 gap-4 mb-6">
                        <x-select.styled label="Tipo *" wire:model="dataFilter.type" wire:change="changeType" required :options="$optionsType" />

                        <x-input
                            wire:model="dataFilter.patientName1"
                            placeholder="Nome do Paciente 1"
                        />
                        @if ($dataFilter['type'] == 'Casal')
                        <x-input
                            wire:model="dataFilter.patientName2"
                            placeholder="Nome do Paciente 2"
                        />
                        @endif
                        <div class="flex justify-end gap-2">
                            <x-button
                                type="submit"
                                text="Filtrar"
                                class="self-end"
                            />
                            <x-button
                                type="button"
                                text="Limpar campos"
                                color="red"
                                class="self-end"
                                wire:click="clearFilter"
                            />
                        </div>
                    </form>
                </x-card>
            </x-slide>
        </div>
        HTML;
    }

    public function setDataFilter()
    {
        $this->dispatch('setDataFilter', $this->dataFilter);
        $this->slide = false;
    }

    public function openFilterModal()
    {
        $this->slide = true;
    }


    public function clearFilter()
    {
        $this->dataFilter = [
            'type' => null,
            'patientName1' => null,
            'patientName2' => null
        ];
    }

    public function changeType($value)
    {
        $this->dataFilter['type'] = $value;
    }
}
