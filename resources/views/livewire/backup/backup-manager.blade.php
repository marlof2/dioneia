<div>
    <x-header title="{{ $title }}" :breadcrumbs="[
        ['label' => 'Backup', 'url' => route('backups.index')],
        ['label' => 'Backups']
    ]" />

    <x-card>
        <x-slot:header>
            <div class="flex items-center justify-between">
                <x-button
                    wire:click="createBackup"
                    :loading="$isCreatingBackup"
                    color="green"
                >
                    <x-icon name="arrow-down-tray" class="w-4 h-4 mr-2" />
                    Criar Backup
                </x-button>
            </div>
        </x-slot:header>

        <!-- Seção de Upload/Restore -->
        <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">Restaurar Backup</h3>
            <p class="text-sm text-blue-700 mb-4">
                Faça upload de um arquivo SQLite para restaurar o banco de dados.
                <strong>⚠️ Atenção:</strong> Esta ação irá substituir o banco atual!
            </p>

            <div class="flex items-center space-x-4">
                <div class="flex-1">
                    <x-input
                        type="file"
                        wire:model="uploadedFile"
                        accept=".sqlite"
                        class="w-full"
                    />
                    @error('uploadedFile')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <x-button
                    wire:click="restoreBackup"
                    :loading="$isRestoring"
                    :disabled="!$uploadedFile"
                    color="red"
                    wire:confirm="⚠️ ATENÇÃO! Esta ação irá substituir completamente o banco de dados atual. Tem certeza que deseja continuar?"
                >
                    <x-icon name="arrow-up-tray" class="w-4 h-4 mr-2" />
                    Restaurar Backup
                </x-button>
            </div>
        </div>

        <div class="space-y-4">
            @if(empty($backups))
                <div class="text-center py-8">
                    <x-icon name="document" class="w-12 h-12 mx-auto text-gray-400 mb-4" />
                    <p class="text-gray-500">Nenhum backup encontrado</p>
                    <p class="text-sm text-gray-400">Clique em "Criar Backup" para fazer o primeiro backup do banco de dados</p>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nome do Arquivo
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tamanho
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Data de Criação
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Ações
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($backups as $backup)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                        {{ $backup['name'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $backup['size'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                        {{ $backup['created_at'] }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                                        <x-button
                                            size="sm"
                                            color="blue"
                                            wire:click="downloadBackup('{{ $backup['name'] }}')"
                                        >
                                            <x-icon name="arrow-down-tray" class="w-4 h-4" />
                                            Baixar
                                        </x-button>

                                        <x-button
                                            size="sm"
                                            color="red"
                                            wire:click="deleteBackup('{{ $backup['name'] }}')"
                                            wire:confirm="Tem certeza que deseja excluir este backup?"
                                        >
                                            <x-icon name="trash" class="w-4 h-4" />
                                            Excluir
                                        </x-button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </x-card>
</div>
