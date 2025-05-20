<div>
    <x-card>
        <x-slot:header>
            <h1 class="text-2xl font-bold">Pacientes</h1>
        </x-slot:header>

        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-6">
                <x-input wire:model.live.debounce.300ms="search" placeholder="Buscar por nome..." />
            </div>
            <div class="col-span-4"></div>
            <div class="col-span-2 ml-auto">
                <x-button icon="plus" :text="__('Novo Paciente')" wire:click="navigateToCreate" />
            </div>
        </div>

        <x-table :$headers :$sort :rows="$this->patients" paginate loading striped :quantity="[10, 15, 20]">

            @interact('column_actions', $row)
                <div class="relative">
                    <x-dropdown icon="ellipsis-vertical" static  position="right">
                        <x-dropdown.items icon="pencil" text="Editar" wire:click="navigateToEdit({{ $row->id }})" />
                        <x-dropdown.items icon="trash" text="Excluir" separator />
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
        </x-table>
    </x-card>
</div>
