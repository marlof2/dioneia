<div>
    <x-modal :title="$title" wire size="full" persistent>
        <x-card bordered>
            <x-step wire:model="currentStep" helpers navigate navigate-previous class="mb-10">
                <hr style="color: gray">
                <!-- Step 1: Dados Pessoais -->
                <x-step.items step="1" title="Dados Pessoais" description="Informações básicas do paciente" clickable>
                    <div class="space-y-6 mt-6">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Pessoais</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Nome Completo</label>
                                    <p class="text-base text-gray-900">{{ $patient->name }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">CPF</label>
                                    <p class="text-base text-gray-900">{{ $patient->cpf }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Data de Nascimento</label>
                                    <p class="text-base text-gray-900">{{ $patient->birth_date ? \Carbon\Carbon::parse($patient->birth_date)->format('d/m/Y') : '' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Idade</label>
                                    <p class="text-base text-gray-900">{{ $patient->age }} anos</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Gênero</label>
                                    <p class="text-base text-gray-900">{{ $patient->gender }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Estado Civil</label>
                                    <p class="text-base text-gray-900">{{ $patient->marital_status }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Número de Filhos</label>
                                    <p class="text-base text-gray-900">{{ $patient->children }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Nome da Mãe</label>
                                    <p class="text-base text-gray-900">{{ $patient->mother_name }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Nome do Pai</label>
                                    <p class="text-base text-gray-900">{{ $patient->father_name }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Responsável Legal</label>
                                    <p class="text-base text-gray-900">{{ $patient->legal_guardian }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-step.items>

                <!-- Step 2: Histórico Familiar -->
                <x-step.items step="2" title="Histórico Familiar" description="Informações sobre o histórico familiar do paciente" clickable>
                    <div class="space-y-6 mt-6">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Histórico Familiar</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Histórico de Suicídio na Família</label>
                                    <p class="text-base text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $patient->family_suicide_history ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $patient->family_suicide_history ? 'Sim' : 'Não' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Histórico de Saúde Mental na Família</label>
                                    <p class="text-base text-gray-900">{{ $patient->family_mental_health_history }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Eventos Significativos na Família</label>
                                    <p class="text-base text-gray-900">{{ $patient->family_significant_events }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-step.items>

                <!-- Step 3: Endereço e Contato -->
                <x-step.items step="3" title="Endereço e Contato" description="Informações de localização e contato" clickable>
                    <div class="space-y-6 mt-6">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Endereço</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Endereço</label>
                                    <p class="text-base text-gray-900">{{ $patient->address }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Cidade</label>
                                    <p class="text-base text-gray-900">{{ $patient->city }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Contatos</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Telefone Principal</label>
                                    <div class="flex items-center gap-2">
                                        <p class="text-base text-gray-900">{{ $patient->phone }}</p>
                                        @if($patient->phone)
                                            <x-button size="xs" icon="chat-bubble-left" color="green" wire:click="openWhatsApp('{{ $patient->phone }}')" />
                                        @endif
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Telefone de Emergência 1</label>
                                    <div class="flex items-center gap-2">
                                        <p class="text-base text-gray-900">{{ $patient->emergency_phone_1 }}</p>
                                        @if($patient->emergency_phone_1)
                                            <x-button size="xs" icon="chat-bubble-left" color="green" wire:click="openWhatsApp('{{ $patient->emergency_phone_1 }}')" />
                                        @endif
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Nome do Contato de Emergência 1</label>
                                    <p class="text-base text-gray-900">{{ $patient->emergency_contact_1 }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Telefone de Emergência 2</label>
                                    <div class="flex items-center gap-2">
                                        <p class="text-base text-gray-900">{{ $patient->emergency_phone_2 }}</p>
                                        @if($patient->emergency_phone_2)
                                            <x-button size="xs" icon="chat-bubble-left" color="green" wire:click="openWhatsApp('{{ $patient->emergency_phone_2 }}')" />
                                        @endif
                                    </div>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Nome do Contato de Emergência 2</label>
                                    <p class="text-base text-gray-900">{{ $patient->emergency_contact_2 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-step.items>

                <!-- Step 4: Informações Adicionais -->
                <x-step.items step="4" title="Informações Adicionais" description="Dados complementares e histórico de saúde" clickable>
                    <div class="space-y-6 mt-6">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Informações Profissionais e Acadêmicas</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Religião</label>
                                    <p class="text-base text-gray-900">{{ $patient->religion }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Nível de Escolaridade</label>
                                    <p class="text-base text-gray-900">{{ $patient->education_level }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Ocupação</label>
                                    <p class="text-base text-gray-900">{{ $patient->occupation }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Histórico de Saúde</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Vícios</label>
                                    <p class="text-base text-gray-900">{{ $patient->vices ?? 'Não informado' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Transtornos</label>
                                    <p class="text-base text-gray-900">{{ $patient->disorders ?? 'Não informado' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Tem ou teve ideação suicida</label>
                                    <p class="text-base text-gray-900">{{ $patient->suicidal_ideation }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Data da Finalização</label>
                                    <p class="text-base text-gray-900">{{ $patient->completion_date ? \Carbon\Carbon::parse($patient->completion_date)->format('d/m/Y') : '' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Observação da Finalização</label>
                                    <p class="text-base text-gray-900">{{ $patient->completion_notes }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-step.items>

                <!-- Step 5: Encaminhamentos -->
                <x-step.items step="5" title="Encaminhamentos" description="Informações sobre encaminhamentos do paciente" clickable>
                    <div class="space-y-6 mt-6">
                        <div class="bg-gray-50 rounded-lg p-6">
                            <h3 class="text-lg font-semibold text-gray-900 mb-4">Detalhes do Encaminhamento</h3>
                            <div class="grid grid-cols-2 gap-6">
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Data do Encaminhamento</label>
                                    <p class="text-base text-gray-900">{{ $patient->referral_date ? \Carbon\Carbon::parse($patient->referral_date)->format('d/m/Y') : '' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Data de Retorno</label>
                                    <p class="text-base text-gray-900">{{ $patient->referral_return_date ? \Carbon\Carbon::parse($patient->referral_return_date)->format('d/m/Y') : '' }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Profissional</label>
                                    <p class="text-base text-gray-900">{{ $patient->referral_professional }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Especialidade</label>
                                    <p class="text-base text-gray-900">{{ $patient->referral_specialty }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Instituição</label>
                                    <p class="text-base text-gray-900">{{ $patient->referral_institution }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Motivo do Encaminhamento</label>
                                    <p class="text-base text-gray-900">{{ $patient->referral_reason }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-step.items>
            </x-step>
        </x-card>
    </x-modal>
</div>
