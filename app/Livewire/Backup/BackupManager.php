<?php

namespace App\Livewire\Backup;

use Livewire\Component;
use Livewire\WithFileUploads;
use TallStackUi\Traits\Interactions;
use App\Livewire\Traits\Alert;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class BackupManager extends Component
{
    use Interactions, Alert, WithFileUploads;

    public $backups = [];
    public $isCreatingBackup = false;
    public $title = 'Gerenciador de Backups';
    public $uploadedFile = null;
    public $isRestoring = false;

    public function mount()
    {
        $this->loadBackups();
    }

    public function loadBackups()
    {
        $backupDir = storage_path('backups');

        if (!file_exists($backupDir)) {
            $this->backups = [];
            return;
        }

        $files = File::files($backupDir);
        $this->backups = collect($files)
            ->filter(function ($file) {
                return pathinfo($file->getFilename(), PATHINFO_EXTENSION) === 'sqlite';
            })
            ->map(function ($file) {
                return [
                    'name' => $file->getFilename(),
                    'size' => $this->formatBytes($file->getSize()),
                    'created_at' => date('d/m/Y H:i:s', $file->getMTime()),
                    'path' => $file->getPathname(),
                ];
            })
            ->sortByDesc('created_at')
            ->values()
            ->toArray();
    }

    public function createBackup()
    {
        try {
            $this->isCreatingBackup = true;

            // Criar diretório de backups se não existir
            $backupDir = storage_path('backups');
            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0777, true);
            }

            // Caminho do banco de dados
            $databasePath = database_path('database.sqlite');

            if (!file_exists($databasePath)) {
                throw new \Exception('Arquivo do banco de dados não encontrado');
            }

            // Nome do arquivo de backup com timestamp
            $backupFileName = 'backup_' . now()->format('d-m-Y') . '.sqlite';
            $backupPath = $backupDir . '/' . $backupFileName;

            // Copiar arquivo do banco
            if (!copy($databasePath, $backupPath)) {
                throw new \Exception('Falha ao copiar arquivo do banco de dados');
            }

            // Recarregar lista de backups
            $this->loadBackups();

            $this->toast()->success('Backup criado!', 'O backup foi salvo com sucesso.')->send();

        } catch (\Exception $e) {
            $this->error('Erro!', 'Falha ao criar backup: ' . $e->getMessage());
        } finally {
            $this->isCreatingBackup = false;
        }
    }

    public function downloadBackup($backupName)
    {
        try {
            $backupPath = storage_path('backups/' . $backupName);

            if (!file_exists($backupPath)) {
                throw new \Exception('Arquivo de backup não encontrado');
            }

            return redirect()->route('backup.download', ['filename' => $backupName]);

        } catch (\Exception $e) {
            $this->error('Erro!', 'Falha ao baixar backup: ' . $e->getMessage());
        }
    }

    public function deleteBackup($backupName)
    {
        try {
            $backupPath = storage_path('backups/' . $backupName);

            if (!file_exists($backupPath)) {
                throw new \Exception('Arquivo de backup não encontrado');
            }

            if (unlink($backupPath)) {
                $this->loadBackups();
                $this->toast()->success('Backup removido!', 'O backup foi excluído com sucesso.')->send();
            } else {
                throw new \Exception('Falha ao excluir arquivo');
            }

        } catch (\Exception $e) {
            $this->error('Erro!', 'Falha ao remover backup: ' . $e->getMessage());
        }
    }

    public function restoreBackup()
    {
        $this->validate([
            'uploadedFile' => 'required|file|extensions:sqlite|max:102400', // 100MB max
        ], [
            'uploadedFile.required' => 'Por favor, selecione um arquivo SQLite.',
            'uploadedFile.file' => 'O arquivo selecionado é inválido.',
            'uploadedFile.extensions' => 'O arquivo deve ser do tipo SQLite (.sqlite).',
            'uploadedFile.max' => 'O arquivo não pode ter mais que 100MB.',
        ]);

        try {
            $this->isRestoring = true;

            // Fazer backup do banco atual antes de restaurar
            $currentDatabasePath = database_path('database.sqlite');
            $backupDir = storage_path('backups');

            if (!file_exists($backupDir)) {
                mkdir($backupDir, 0777, true);
            }

            // Criar backup do banco atual antes de substituir
            $backupFileName = 'backup_antes_da_restauração_' . now()->format('d-m-Y') . '.sqlite';
            $backupPath = $backupDir . '/' . $backupFileName;

            if (file_exists($currentDatabasePath)) {
                copy($currentDatabasePath, $backupPath);
            }

            // Substituir o banco atual pelo arquivo enviado
            $uploadedPath = $this->uploadedFile->getRealPath();

            if (!copy($uploadedPath, $currentDatabasePath)) {
                throw new \Exception('Falha ao restaurar banco de dados');
            }

            // Limpar o arquivo enviado
            $this->uploadedFile = null;

            // Recarregar lista de backups
            $this->loadBackups();

            $this->toast()->success('Backup restaurado!', 'O banco de dados foi restaurado com sucesso.')->send();

        } catch (\Exception $e) {
            $this->error('Erro!', 'Falha ao restaurar backup: ' . $e->getMessage());
        } finally {
            $this->isRestoring = false;
        }
    }


    private function formatBytes($size, $precision = 2)
    {
        $units = ['B', 'KB', 'MB', 'GB', 'TB'];

        for ($i = 0; $size > 1024 && $i < count($units) - 1; $i++) {
            $size /= 1024;
        }

        return round($size, $precision) . ' ' . $units[$i];
    }

    public function render()
    {
        return view('livewire.backup.backup-manager');
    }
}
