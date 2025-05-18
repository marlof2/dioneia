<div>
    <x-card>
        <x-slot:header>
            <h1 class="text-2xl font-bold">Pacientes</h1>
        </x-slot:header>

        <div class="flex justify-start mb-4">
            <x-button icon="plus" sm :text="__('Novo Paciente')" wire:click="navigateToCreate" />
        </div>

        <x-table :$headers :$sort :rows="$this->patients" paginate filter loading striped :quantity="[10, 15, 20]">

            @interact('column_actions', $row)
                <div class="relative">
                    <x-dropdown>
                        <x-slot:action>
                            <x-button.circle icon="ellipsis-vertical" x-on:click="show = !show" sm outline color="gray" />
                        </x-slot:action>
                        <x-dropdown.items icon="pencil" text="Editar" wire:click="loadPatient({{ $row->id }})" />
                        <x-dropdown.items icon="trash" text="Excluir" separator />
                    </x-dropdown>
                </div>
            @endinteract
        </x-table>
    </x-card>
</div>
