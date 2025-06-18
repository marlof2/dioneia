    <div>
        <x-modal :title="$title" wire size="7xl" persistent>
            <form wire:submit="save" class="grid grid-cols-1 gap-4 mb-6">
                @if (session()->has('error'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => { show = false; $wire.dispatch('error-hidden') }, 10000)"
                    >
                        <x-alert
                            title="Atenção!"
                            icon="exclamation-triangle"
                            color="orange"
                            class="mb-4">
                            {{ session('error') }}
                        </x-alert>
                    </div>
                @endif
                <x-select.styled label="Tipo *" wire:model="form.type" wire:change="changeType" :options="$optionsType" />
                <x-select.styled label="Paciente 1 *" wire:model="form.patient1_id" clearable :options="$itemsPatient" searchable
                    select="label:name|value:id" />
                @if ($form->type == 'Casal')
                    <x-select.styled label="Paciente 2" wire:model="form.patient2_id" :options="$itemsPatient" searchable
                        select="label:name|value:id" />
                @endif
                <x-button type="submit" :text="__($isEdit ? 'Editar' : 'Adicionar')" class="self-end" />
            </form>
        </x-modal>
    </div>
