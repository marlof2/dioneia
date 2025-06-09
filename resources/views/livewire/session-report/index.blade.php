<div>
    <x-header title="Relato de Sessão" :breadcrumbs="[['label' => 'Prontuário', 'url' => route('promptuary.index')], ['label' => 'Relato de Sessão']]" />
    <x-card>
        <div class="grid grid-cols-12 gap-4 mb-4">
            <div class="col-span-6">
                <x-input wire:model.live.debounce.300ms="search" placeholder="Buscar por data..." />
            </div>
            <div class="col-span-4"></div>
            <div class="col-span-2 ml-auto">
                <x-button icon="plus" :text="__('Novo Relato')"
                    wire:click="$dispatch('open-modal::session-report-form', { id: null })" />
            </div>
        </div>
        <x-table :$headers :rows="$this->itensTable" paginate striped>
            @interact('column_actions', $row)
                <div class="relative">
                    <x-dropdown icon="ellipsis-vertical" static position="right">
                        <x-dropdown.items icon="pencil" text="Editar"
                            wire:click="$dispatch('open-modal::session-report-form', { id: {{ $row->id }} })" />
                        <x-dropdown.items icon="trash" text="Excluir" separator
                            wire:click="$dispatch('open-modal::session-report-delete', { sessionReport: {{ $row->id }} })" />
                    </x-dropdown>
                </div>
            @endinteract

            @interact('column_created_at', $row)
                <div class="flex items-center gap-2">
                    <span>{{ $this->dateFormatted($row->created_at) }}</span>
                </div>
            @endinteract
        </x-table>
    </x-card>

    <x-modal wire title="Relato de Sessão" size="7xl" persistent>
        <div class="grid grid-cols-1 gap-4">
            <!-- Patient Information Section -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold">@php echo $promptuary->type == 'Individual' ? 'Informações do Paciente' : 'Informações dos Pacientes'; @endphp</h3>
                    <x-button icon="chevron-down" wire:click="togglePatientInfo" />
                </div>

                <div x-show="$wire.showPatientInfo" x-transition>
                    <div class="grid grid-cols-1 @if($promptuary->type === 'Casal' && $promptuary->patient2) md:grid-cols-2 @endif gap-4">
                        <!-- Patient 1 -->
                        <div class="bg-white p-4 rounded-lg shadow">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="font-semibold">Paciente 1</h4>
                                <a href="{{ route('patients.edit', $promptuary->patient1->id) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800">
                                    <x-button icon="pencil" text="Editar" sm />
                                </a>
                            </div>
                            <div class="space-y-2">
                                <p><span class="font-medium">Nome:</span> {{ $promptuary->patient1->name }}</p>
                                <p><span class="font-medium">CPF:</span> {{ $promptuary->patient1->cpf }}</p>
                                <p><span class="font-medium">Data de Nascimento:</span>
                                    {{ $this->dateFormatted($promptuary->patient1->birth_date) }}</p>
                                <p><span class="font-medium">Idade:</span> {{ $promptuary->patient1->age }}</p>
                                <p><span class="font-medium">Gênero:</span> {{ $promptuary->patient1->gender }}</p>
                                <p><span class="font-medium">Estado Civil:</span>
                                    {{ $promptuary->patient1->marital_status }}</p>
                                <p><span class="font-medium">Filhos:</span> {{ $promptuary->patient1->children }}</p>
                                <p><span class="font-medium">Endereço:</span> {{ $promptuary->patient1->address }}</p>
                                <p><span class="font-medium">Cidade:</span> {{ $promptuary->patient1->city }}</p>
                                <p><span class="font-medium">Telefone:</span> {{ $promptuary->patient1->phone }}</p>
                                <p><span class="font-medium">Religião:</span> {{ $promptuary->patient1->religion }}</p>
                                <p><span class="font-medium">Escolaridade:</span>
                                    {{ $promptuary->patient1->education_level }}</p>
                                <p><span class="font-medium">Ocupação:</span> {{ $promptuary->patient1->occupation }}
                                </p>

                                @if ($promptuary->patient1->vices)
                                    <div>
                                        <span class="font-medium">Vícios:</span>
                                        <ul class="list-disc list-inside">
                                            @foreach ($promptuary->patient1->vices as $vice)
                                                <li>{{ $vice }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <p><span class="font-medium">Vícios:</span> Não informado</p>
                                @endif

                                <p><span class="font-medium">Histórico de Suicídio na Família:</span>
                                    {{ $promptuary->patient1->family_suicide_history ? 'Sim' : 'Não' }}</p>
                                <p><span class="font-medium">Pensamentos Suicidas:</span>
                                    {{ $promptuary->patient1->suicidal_thoughts ? 'Sim' : 'Não' }}</p>

                                @if ($promptuary->patient1->disorders)
                                    <div>
                                        <span class="font-medium">Transtornos:</span>
                                        <ul class="list-disc list-inside">
                                            @foreach ($promptuary->patient1->disorders as $disorder)
                                                <li>{{ $disorder }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @else
                                    <p><span class="font-medium">Transtornos:</span> Não informado</p>
                                @endif


                            </div>
                        </div>

                        <!-- Patient 2 (if exists) -->
                        @if ($promptuary->type === 'Casal' && $promptuary->patient2)
                            <div class="bg-white p-4 rounded-lg shadow">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="font-semibold">Paciente 2</h4>
                                    <a href="{{ route('patients.edit', $promptuary->patient2->id) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800">
                                        <x-button icon="pencil" text="Editar" sm />
                                    </a>
                                </div>
                                <div class="space-y-2">
                                    <p><span class="font-medium">Nome:</span> {{ $promptuary->patient2->name }}</p>
                                    <p><span class="font-medium">CPF:</span> {{ $promptuary->patient2->cpf }}</p>
                                    <p><span class="font-medium">Data de Nascimento:</span>
                                        {{ $this->dateFormatted($promptuary->patient2->birth_date) }}</p>
                                    <p><span class="font-medium">Idade:</span> {{ $promptuary->patient2->age }}</p>
                                    <p><span class="font-medium">Gênero:</span> {{ $promptuary->patient2->gender }}</p>
                                    <p><span class="font-medium">Estado Civil:</span>
                                        {{ $promptuary->patient2->marital_status }}</p>
                                    <p><span class="font-medium">Filhos:</span> {{ $promptuary->patient2->children }}
                                    </p>
                                    <p><span class="font-medium">Endereço:</span> {{ $promptuary->patient2->address }}
                                    </p>
                                    <p><span class="font-medium">Cidade:</span> {{ $promptuary->patient2->city }}</p>
                                    <p><span class="font-medium">Telefone:</span> {{ $promptuary->patient2->phone }}
                                    </p>
                                    <p><span class="font-medium">Religião:</span> {{ $promptuary->patient2->religion }}
                                    </p>
                                    <p><span class="font-medium">Escolaridade:</span>
                                        {{ $promptuary->patient2->education_level }}</p>
                                    <p><span class="font-medium">Ocupação:</span>
                                        {{ $promptuary->patient2->occupation }}</p>

                                    @if ($promptuary->patient2->vices)
                                        <div>
                                            <span class="font-medium">Vícios:</span>
                                            <ul class="list-disc list-inside">
                                                @foreach ($promptuary->patient2->vices as $vice)
                                                    <li>{{ $vice }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p><span class="font-medium">Vícios:</span> Não informado</p>
                                    @endif

                                    <p><span class="font-medium">Histórico de Suicídio na Família:</span>
                                        {{ $promptuary->patient2->family_suicide_history ? 'Sim' : 'Não' }}</p>
                                    <p><span class="font-medium">Pensamentos Suicidas:</span>
                                        {{ $promptuary->patient2->suicidal_thoughts ? 'Sim' : 'Não' }}</p>

                                    @if ($promptuary->patient2->disorders)
                                        <div>
                                            <span class="font-medium">Transtornos:</span>
                                            <ul class="list-disc list-inside">
                                                @foreach ($promptuary->patient2->disorders as $disorder)
                                                    <li>{{ $disorder }}</li>
                                                @endforeach
                                            </ul>
                                        </div>
                                    @else
                                        <p><span class="font-medium">Transtornos:</span> Não informado</p>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Session Report Form -->
            <form wire:submit="save" class="space-y-4">
                <x-textarea wire:model="form.text" label="Relato da Sessão" placeholder="Digite o relato da sessão..."
                    rows="10" required />

                <div class="flex justify-end gap-2">
                    <x-button type="submit" text="Salvar" />
                </div>
            </form>
        </div>
    </x-modal>
    <x-loading />

</div>
