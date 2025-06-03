<div>
    <x-header title="{{ $title }}" :breadcrumbs="[['label' => 'Prontuário']]" />
    <x-card>
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-6">
                <x-input wire:model.live.debounce.300ms="search" placeholder="Buscar por nome..." />
            </div>
            <div class="col-span-4"></div>
            <div class="col-span-2 ml-auto">
                <x-button icon="plus" :text="__('Novo Prontuário')" wire:click="$dispatch('open-modal::promptuary-form', { id: null })" />
            </div>
        </div>

        <x-table :$headers :rows="$this->itensTable" paginate striped >

            @interact('column_actions', $row)
                <div class="relative">
                    <x-dropdown icon="ellipsis-vertical" static position="right">
                        <x-dropdown.items icon="pencil" text="Editar" wire:click="dispatch('open-modal::promptuary-form', { id: {{ $row->id }} })" />
                        {{-- <x-dropdown.items icon="clipboard" text="Situação Clínica" wire:click="dispatch('open-modal::clinical-situation', { id: {{ $row->id }} })" /> --}}
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

    <livewire:promptuary.create @refresh="$refresh" />
</div>
