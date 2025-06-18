<x-modal wire title="Upload de Documento" persistent size="7xl">
    <form wire:submit="save">
        <div class="space-y-4">
            <div>
                <x-input label="Nome do Documento" wire:model="name" id="name" type="text" class="w-full" />
                @error('name')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <x-upload
                    wire:model="uploadedFile"
                    label="Arquivo"
                    hint="Arquivos permitidos: Word (.doc, .docx), Excel (.xls, .xlsx), PDF (.pdf) e imagens (.jpg, .jpeg, .png)"
                    tip="Clique para fazer upload"
                    delete
                />
                @error('uploadedFile')
                    <span class="text-red-600 text-sm">{{ $message }}</span>
                @enderror
            </div>
        </div>

        <div class="mt-6 flex justify-end gap-2">
            <x-button type="button" wire:click="closeModal" color="secondary">
                Cancelar
            </x-button>
            <x-button type="submit">
                Enviar
            </x-button>
        </div>
    </form>

    <div class="mt-8">
        <h3 class="text-lg font-medium text-gray-900 mb-4">Documentos</h3>

        <x-table :headers="$headers" :rows="$documents" striped>
            @interact('column_actions', $row)
                <div class="relative">
                    <x-dropdown icon="ellipsis-vertical" static position="right">
                        @if (in_array($row->mime_type, ['image/jpeg', 'image/png', 'image/jpg', 'application/pdf']))
                        <x-dropdown.items
                            icon="eye"
                            text="Visualizar"
                            href="{{ Storage::url($row->path) }}"
                            target="_blank"
                        />
                        @endif
                        <x-dropdown.items
                            icon="arrow-down-tray"
                            text="Baixar"
                            href="{{ Storage::url($row->path) }}"
                            :download="$row->name"
                        />
                        <x-dropdown.items icon="trash" text="Excluir" separator wire:click="delete({{ $row->id }})" />
                    </x-dropdown>
                </div>
            @endinteract

            @interact('column_size', $row)
                <div class="flex items-center gap-2">
                    <x-icon name="document" class="h-5 w-5" />
                    <span>{{ number_format($row->size / 1024, 2) }} KB</span>
                </div>
            @endinteract

            @interact('column_type', $row)
                <div class="flex items-center gap-2">
                    <x-icon name="document-text" class="h-5 w-5" />
                    <span>{{ $row->mime_type }}</span>
                </div>
            @endinteract
        </x-table>
    </div>
</x-modal>
