<div>
    <x-header title="{{ $title }}" :breadcrumbs="[['label' => 'Pacientes']]" />
    <x-card>
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-6">
                <x-input wire:model.live.debounce.300ms="search" placeholder="Buscar por nome..." />
            </div>
            <div class="col-span-4"></div>
            <div class="col-span-2 ml-auto">
                <x-button icon="plus" :text="__('Novo Paciente')" wire:click="navigateToCreate" />
            </div>
        </div>

        <x-table :$headers :rows="$this->patients" paginate striped >

            @interact('column_actions', $row)
                <div class="relative">
                    <x-dropdown icon="ellipsis-vertical" static position="right">
                        <x-dropdown.items icon="pencil" text="Editar" wire:click="navigateToEdit({{ $row->id }})" />
                        <x-dropdown.items icon="clipboard" text="Situação Clínica" wire:click="dispatch('open-modal::clinical-situation', { id: {{ $row->id }} })" />
                        <x-dropdown.items icon="trash" text="Excluir" separator wire:click="dispatch('patient-delete', { id: {{ $row->id }} })" />
                    </x-dropdown>
                </div>
            @endinteract

            @interact('column_birth_date', $row)
                <div class="flex items-center gap-2">
                    <x-icon name="calendar" class="h-5 w-5" />
                    <span>{{ $this->dateFormatted($row->birth_date) }}
                        {{ $this->isBirthday($row->birth_date) ? '🎉' : '' }}</span>
                </div>
            @endinteract
            @interact('column_created_at', $row)
                <div class="flex items-center gap-2">
                    <span>{{ $this->dateFormatted($row->created_at) }}</span>
                </div>
            @endinteract
        </x-table>
    </x-card>

    <livewire:patient.clinical-situation-create />
</div>
