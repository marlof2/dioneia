<div>
    <x-header title="{{ $title }}" :breadcrumbs="[['label' => 'Pacientes']]" />
    <x-card>
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-6">
                <x-input wire:model.live.debounce.300ms="search" placeholder="Buscar por nome..." class="focus:ring-blue-500 focus:border-blue-500" />
            </div>
            <div class="col-span-4"></div>
            <div class="col-span-2 ml-auto">
                <x-button icon="plus" :text="__('Novo Paciente')" wire:click="navigateToCreate" color="blue" />
            </div>
        </div>

        <x-table :$headers :rows="$this->patients" paginate striped >

            @interact('column_actions', $row)
                <div class="relative">
                    <x-dropdown icon="ellipsis-vertical" static position="right" class="text-gray-600 hover:text-gray-800">
                        <x-dropdown.items icon="eye" text="Visualizar" wire:click="$dispatch('open-modal::patient-view', { id: {{ $row->id }} })" class="text-blue-600 hover:text-blue-700" />
                        <x-dropdown.items icon="pencil" text="Editar" wire:click="navigateToEdit({{ $row->id }})" class="hover:text-yellow-700" />
                        <x-dropdown.items icon="clipboard" text="Situação Clínica" wire:click="dispatch('open-modal::clinical-situation', { id: {{ $row->id }} })" class="text-purple-600 hover:text-purple-700" />
                        <x-dropdown.items icon="document" text="Upload de Documento" wire:click="dispatch('open-modal::document-upload', { id: {{ $row->id }} })" class="text-indigo-600 hover:text-indigo-700" />
                        @if($row->phone)
                            <x-dropdown.items icon="chat-bubble-left" text="WhatsApp" wire:click="openWhatsApp('{{ $row->phone }}')" class="text-green-600 hover:text-green-700" />
                        @endif
                        <x-dropdown.items icon="trash" text="Excluir" separator wire:click="dispatch('patient-delete', { id: {{ $row->id }} })" class="text-red-600 hover:text-red-700" />
                    </x-dropdown>
                </div>
            @endinteract

            @interact('column_birth_date', $row)
                <div class="flex items-center gap-2">
                    <x-icon name="calendar" class="h-5 w-5 text-blue-500" />
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
    <livewire:patient.view-modal />
    <livewire:patient.document-upload />
</div>
