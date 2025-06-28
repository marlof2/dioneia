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
        <div class="space-y-6">
            <!-- Patient Information Section -->
            <div class="bg-gray-50 p-6 rounded-lg">
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-xl font-semibold text-gray-900">
                        @php echo $promptuary->type == 'Individual' ? 'Informações do Paciente' : 'Informações dos Pacientes'; @endphp
                    </h3>
                    <x-button icon="chevron-down" wire:click="togglePatientInfo" />
                </div>

                <div x-show="$wire.showPatientInfo" x-transition>
                    <div class="grid grid-cols-1 @if ($promptuary->type === 'Casal' && $promptuary->patient2) lg:grid-cols-2 @endif gap-6">
                        <!-- Patient 1 -->
                        <div class="bg-white p-6 rounded-lg">
                            <div class="flex justify-between items-center mb-4">
                                <h4 class="text-lg font-semibold text-gray-900">Paciente 1</h4>
                                <a href="{{ route('patients.edit', $promptuary->patient1->id) }}" target="_blank"
                                    class="text-blue-600 hover:text-blue-800">
                                    <x-button icon="pencil" text="Editar" sm />
                                </a>
                            </div>

                            <!-- Dados Pessoais -->
                            <div class="mb-8">
                                <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Dados Pessoais</h5>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Nome Completo</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->name }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">CPF</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->cpf }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Data de Nascimento</label>
                                        <p class="text-base text-gray-900">{{ $this->dateFormatted($promptuary->patient1->birth_date) }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Idade</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->age }} anos</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Gênero</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->gender }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Estado Civil</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->marital_status }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Número de Filhos</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->children }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Nome da Mãe</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->mother_name }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Nome do Pai</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->father_name }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Responsável Legal</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->legal_guardian }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Endereço e Contato -->
                            <div class="mb-8">
                                <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Endereço e Contato</h5>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Endereço</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->address }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Cidade</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->city }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Telefone Principal</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->phone }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Telefone de Emergência 1</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->emergency_phone_1 }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Nome do Contato de Emergência 1</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->emergency_contact_1 }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Telefone de Emergência 2</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->emergency_phone_2 }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Nome do Contato de Emergência 2</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->emergency_contact_2 }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Informações Profissionais -->
                            <div class="mb-8">
                                <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Informações Profissionais</h5>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Religião</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->religion }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Nível de Escolaridade</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->education_level }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Ocupação</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->occupation }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Histórico de Saúde -->
                            <div class="mb-8">
                                <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Histórico de Saúde</h5>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Vícios</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->vices ?? 'Não informado' }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Transtornos</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->disorders ?? 'Não informado' }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Ideação Suicida</label>
                                        <p class="text-base text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $promptuary->patient1->suicidal_ideation == 1 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $promptuary->patient1->suicidal_ideation == 1 ? 'Sim' : 'Não' }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Data da Finalização</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->completion_date ? $this->dateFormatted($promptuary->patient1->completion_date) : '' }}</p>
                                    </div>
                                    <div class="space-y-1 col-span-2">
                                        <label class="text-sm font-medium text-gray-500">Observação da Finalização</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->completion_notes }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Histórico Familiar -->
                            <div class="mb-8">
                                <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Histórico Familiar</h5>
                                <div class="grid grid-cols-1 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Histórico de Suicídio na Família</label>
                                        <p class="text-base text-gray-900">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $promptuary->patient1->family_suicide_history ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                {{ $promptuary->patient1->family_suicide_history ? 'Sim' : 'Não' }}
                                            </span>
                                        </p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Histórico de Saúde Mental na Família</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->family_mental_health_history }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Eventos Significativos na Família</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->family_significant_events }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Encaminhamentos -->
                            <div class="mb-8">
                                <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Encaminhamentos</h5>
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Data do Encaminhamento</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->referral_date ? $this->dateFormatted($promptuary->patient1->referral_date) : '' }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Data de Retorno</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->referral_return_date ? $this->dateFormatted($promptuary->patient1->referral_return_date) : '' }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Profissional</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->referral_professional }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Especialidade</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->referral_specialty }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Instituição</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->referral_institution }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <label class="text-sm font-medium text-gray-500">Motivo do Encaminhamento</label>
                                        <p class="text-base text-gray-900">{{ $promptuary->patient1->referral_reason }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Patient 2 (if exists) -->
                        @if ($promptuary->type === 'Casal' && $promptuary->patient2)
                            <div class="bg-white p-6 rounded-lg">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-lg font-semibold text-gray-900">Paciente 2</h4>
                                    <a href="{{ route('patients.edit', $promptuary->patient2->id) }}" target="_blank"
                                        class="text-blue-600 hover:text-blue-800">
                                        <x-button icon="pencil" text="Editar" sm />
                                    </a>
                                </div>

                                <!-- Dados Pessoais -->
                                <div class="mb-8">
                                    <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Dados Pessoais</h5>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Nome Completo</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->name }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">CPF</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->cpf }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Data de Nascimento</label>
                                            <p class="text-base text-gray-900">{{ $this->dateFormatted($promptuary->patient2->birth_date) }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Idade</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->age }} anos</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Gênero</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->gender }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Estado Civil</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->marital_status }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Número de Filhos</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->children }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Nome da Mãe</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->mother_name }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Nome do Pai</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->father_name }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Responsável Legal</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->legal_guardian }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Endereço e Contato -->
                                <div class="mb-8">
                                    <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Endereço e Contato</h5>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Endereço</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->address }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Cidade</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->city }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Telefone Principal</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->phone }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Telefone de Emergência 1</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->emergency_phone_1 }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Nome do Contato de Emergência 1</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->emergency_contact_1 }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Telefone de Emergência 2</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->emergency_phone_2 }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Nome do Contato de Emergência 2</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->emergency_contact_2 }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informações Profissionais -->
                                <div class="mb-8">
                                    <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Informações Profissionais</h5>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Religião</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->religion }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Nível de Escolaridade</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->education_level }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Ocupação</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->occupation }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Histórico de Saúde -->
                                <div class="mb-8">
                                    <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Histórico de Saúde</h5>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Vícios</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->vices ?? 'Não informado' }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Transtornos</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->disorders ?? 'Não informado' }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Ideação Suicida</label>
                                            <p class="text-base text-gray-900">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $promptuary->patient2->suicidal_ideation == 1 ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $promptuary->patient2->suicidal_ideation == 1 ? 'Sim' : 'Não' }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Data da Finalização</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->completion_date ? $this->dateFormatted($promptuary->patient2->completion_date) : '' }}</p>
                                        </div>
                                        <div class="space-y-1 col-span-2">
                                            <label class="text-sm font-medium text-gray-500">Observação da Finalização</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->completion_notes }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Histórico Familiar -->
                                <div class="mb-8">
                                    <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Histórico Familiar</h5>
                                    <div class="grid grid-cols-1 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Histórico de Suicídio na Família</label>
                                            <p class="text-base text-gray-900">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $promptuary->patient2->family_suicide_history ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                                    {{ $promptuary->patient2->family_suicide_history ? 'Sim' : 'Não' }}
                                                </span>
                                            </p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Histórico de Saúde Mental na Família</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->family_mental_health_history }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Eventos Significativos na Família</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->family_significant_events }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Encaminhamentos -->
                                <div class="mb-8">
                                    <h5 class="text-lg font-semibold text-gray-900 mb-4 border-b border-gray-200 pb-2">Encaminhamentos</h5>
                                    <div class="grid grid-cols-2 gap-4">
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Data do Encaminhamento</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->referral_date ? $this->dateFormatted($promptuary->patient2->referral_date) : '' }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Data de Retorno</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->referral_return_date ? $this->dateFormatted($promptuary->patient2->referral_return_date) : '' }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Profissional</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->referral_professional }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Especialidade</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->referral_specialty }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Instituição</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->referral_institution }}</p>
                                        </div>
                                        <div class="space-y-1">
                                            <label class="text-sm font-medium text-gray-500">Motivo do Encaminhamento</label>
                                            <p class="text-base text-gray-900">{{ $promptuary->patient2->referral_reason }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Session Report Form -->
            <div class="bg-white p-6 rounded-lg">
                <form wire:submit="save" class="space-y-4">
                    <x-textarea wire:model="form.text" label="Relato da Sessão"
                        placeholder="Digite o relato da sessão..." rows="10" required />

                    <div class="flex justify-end gap-2">
                        <x-button type="button" text="Fechar" wire:click="closeModal" color="gray" />
                        <x-button type="submit" text="Salvar" />
                    </div>
                </form>
            </div>
        </div>
    </x-modal>
    <x-loading />

</div>
