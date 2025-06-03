<div>

    <x-modal title="Situação Clínica" wire size="7xl" persistent>
        <x-card bordered>
            <form wire:submit="save" class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                <x-input label="Médico *" wire:model="form.doctor" required />
                <x-input label="Medicamentação *" wire:model="form.medication" required />
                <x-button type="submit" :text="__($isEdit ? 'Editar' : 'Adicionar')" class="self-end" />
            </form>

            <x-table :$headers :rows="$rows" striped loading>
                @interact('column_actions', $row)
                    <div class="relative">
                        <x-dropdown icon="ellipsis-vertical" static position="right">
                            <x-dropdown.items icon="pencil" text="Editar" wire:click="setFormData({{ $row->id }})" />
                            <x-dropdown.items icon="trash" text="Excluir" separator
                                wire:click="$dispatch('delete::clinical-situation', { id: {{ $row->id }} })" />
                        </x-dropdown>
                    </div>
                @endinteract
            </x-table>
        </x-card>
    </x-modal>

</div>
