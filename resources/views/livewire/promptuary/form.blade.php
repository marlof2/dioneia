    <div>
        <x-modal :title="$title" wire size="7xl" persistent>
            <form wire:submit="save" class="grid grid-cols-1 gap-4 mb-6">
                @if ($errors)
                    <x-alert title="Atenção!" icon="exclamation-triangle" color="red" class="mb-4" close>
                        @foreach ($errors as $error)
                            {{ $error[0] }}<br>
                        @endforeach
                    </x-alert>
                @endif
                <x-select.styled label="Tipo *" wire:model="form.type" wire:change="changeType" required :options="$optionsType" />
                <x-select.styled label="Paciente 1 *" wire:model="form.patient1_id" required :options="$itemsPatient" searchable
                    select="label:name|value:id" clearable />
                @if ($form->type == 'Casal')
                    <x-select.styled label="Paciente 2" wire:model="form.patient2_id" required :options="$itemsPatient" searchable
                        select="label:name|value:id" />
                @endif
                <x-button type="submit" :text="__($isEdit ? 'Editar' : 'Adicionar')" class="self-end" />
            </form>
        </x-modal>
    </div>
