<?php

namespace App\Livewire\Patient;

use App\Models\Document;
use App\Models\Patient;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Rule;
use TallStackUi\Traits\Interactions;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;

class DocumentUpload extends Component
{
    use WithFileUploads, Interactions;

    public Patient $patient;
    public $name;
    public $modal = false;
    public $uploadedFile;

    public $headers = [
        ['index' => 'name', 'label' => 'Nome', 'sortable' => true],
        ['index' => 'type', 'label' => 'Tipo', 'sortable' => true],
        ['index' => 'size', 'label' => 'Tamanho', 'sortable' => true],
        ['index' => 'actions', 'label' => 'Ações', 'sortable' => false],
    ];


    protected $rules = [
        'uploadedFile' => 'required|file|max:10240|mimes:doc,docx,xls,xlsx,pdf,jpg,jpeg,png',
        'name' => 'required|string|max:255',
    ];

    public function mount(Patient $patient)
    {
        $this->patient = $patient;
    }

    public function save()
    {
        $this->validate();

        $path = $this->uploadedFile->store('documents/' . $this->patient->id, 'public');

        Document::create([
            'patient_id' => $this->patient->id,
            'path' => $path,
            'name' => $this->name,
            'mime_type' => $this->uploadedFile->getMimeType(),
            'size' => $this->uploadedFile->getSize(),
        ]);

        $this->reset(['uploadedFile', 'name']);
        $this->dispatch('document-uploaded');
        $this->dispatch('close-modal', 'document-upload');
        $this->toast()->success('Sucesso', 'Documento enviado com sucesso!')->send();
    }

    public function delete(Document $document)
    {
        // Remove o arquivo físico
        if (file_exists(storage_path('app/public/' . $document->path))) {
            unlink(storage_path('app/public/' . $document->path));
        }

        // Remove o registro do banco
        $document->delete();

        $this->toast()->success('Sucesso', 'Documento excluído com sucesso!')->send();
    }

    public function deleteUpload(array $content): void
    {
        if (!$this->uploadedFile) {
            return;
        }

        $files = Arr::wrap($this->uploadedFile);

        /** @var UploadedFile $file */
        $file = collect($files)->filter(fn (UploadedFile $item) => $item->getFilename() === $content['temporary_name'])->first();

        // 1. Aqui excluímos o arquivo. Mesmo se tivermos um erro aqui, simplesmente
        // ignoramos porque enquanto o arquivo não for persistido, ele é
        // temporário e será excluído em algum momento se houver uma falha aqui.
        rescue(fn () => $file->delete(), report: false);

        $collect = collect($files)->filter(fn (UploadedFile $item) => $item->getFilename() !== $content['temporary_name']);

        // 2. Garantimos a restauração dos arquivos restantes independentemente do tipo de upload
        // seja você lidando com uploads múltiplos ou únicos
        $this->uploadedFile = is_array($this->uploadedFile) ? $collect->toArray() : $collect->first();
    }

    public function render()
    {
        return view('livewire.patient.document-upload', [
            'documents' => $this->patient->documents()->latest()->get()
        ]);
    }

    #[On('open-modal::document-upload')]
    public function openDocumentUploadModal($id)
    {
        $this->patient = Patient::findOrFail($id);
        $this->modal = true;
    }

    public function closeModal()
    {
        $this->modal = false;
    }
}
