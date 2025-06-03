<div>
    <x-header title="Usuários" :breadcrumbs="[['label' => 'Usuários']]" />
    <x-card>
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-6">
                <x-input wire:model.live.debounce.300ms="search" placeholder="Buscar por nome ou email..." />
            </div>
            <div class="col-span-4"></div>
            <div class="col-span-2 ml-auto">
                <livewire:users.create @created="$refresh" />
            </div>
        </div>

        <x-table :$headers :$sort :rows="$this->rows" paginate striped loading>
            @interact('column_created_at', $row)
                {{ $row->created_at->diffForHumans() }}
            @endinteract

            @interact('column_action', $row)
                <div class="flex gap-1">
                    <x-button.circle icon="pencil" wire:click="$dispatch('load::user', { 'user' : '{{ $row->id }}'})" />
                    <livewire:users.delete :user="$row" :key="uniqid('', true)" @deleted="$refresh" />
                </div>
            @endinteract
        </x-table>

        {{ $this->rows->links() }}
    </x-card>

    <livewire:users.update @updated="$refresh" />
</div>
