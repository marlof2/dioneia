<div>
    <x-header title="{{ $title }}" :breadcrumbs="[['label' => 'Prontuário']]" />
    <x-card>
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-6">
                <livewire:promptuary.filter @setDataFilter="setDataFilter" />
            </div>
            <div class="col-span-4"></div>
            <div class="col-span-2 ml-auto">
                <x-button icon="plus" :text="__('Novo Prontuário')" wire:click="$dispatch('open-modal::promptuary-form', { id: null })" />
            </div>
        </div>

        <x-table :$headers :rows="$this->itensTable" paginate striped loading>

            @interact('column_actions', $row)
                <div class="relative">
                    <x-dropdown icon="ellipsis-vertical" static position="right">
                        <x-dropdown.items icon="pencil" text="Editar Prontuário" wire:click="dispatch('open-modal::promptuary-form', { id: {{ $row->id }} })" />
                        <x-dropdown.items icon="user" text="Visualizar Paciente 1" separator wire:click="$dispatch('open-modal::patient-view', { id: {{ $row->patient1->id }} })" />
                        @if($row->patient2)
                            <x-dropdown.items icon="user" text="Visualizar Paciente 2" separator wire:click="$dispatch('open-modal::patient-view', { id: {{ $row->patient2->id }} })" />
                        @endif
                        <x-dropdown.items icon="document-plus" text="Relato de Sessão" separator wire:click="navigateToSessionReport({{ $row->id }})" />
                        <x-dropdown.items icon="trash" text="Excluir" separator wire:click="dispatch('open-modal::promptuary-delete', { promptuary: {{ $row->id }} })" />
                    </x-dropdown>
                </div>
            @endinteract

            @interact('column_created_at', $row)
                <div class="flex items-center gap-2">
                    <span>{{ $this->dateFormatted($row->created_at) }}</span>
                </div>
            @endinteract
        </x-table>
    </x-card>
    {{-- <x-loading /> --}}
    <livewire:promptuary.create @refresh="$refresh" />
    <livewire:patient.view-modal />
</div>
