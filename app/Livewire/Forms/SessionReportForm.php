<?php

namespace App\Livewire\Forms;

use Livewire\Attributes\Validate;
use Livewire\Form;

class SessionReportForm extends Form
{
    public ?int $id = null;
    public ?string $text = null;

    public function rules(): array
    {
        return [
            'text' => 'required|string',
        ];
    }

    public function messages(): array
    {
        return [
            'text.required' => 'O relato da sessão é obrigatório',
        ];
    }
}
