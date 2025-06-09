<div>
    <x-modal :title="$title" wire size="7xl" persistent>
        <x-card bordered>
            <x-step wire:model="currentStep" helpers navigate-previous class="mb-10">
                <!-- Step 1: Dados Pessoais -->
                <x-step.items step="1" title="Dados Pessoais" description="Informações básicas do paciente">
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
                            </div>
                        </div>
                    </div>
                </x-step.items>

                <!-- Step 2: Endereço e Contato -->
                <x-step.items step="2" title="Endereço e Contato" description="Informações de localização e contato">
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
                                    <p class="text-base text-gray-900">{{ $patient->phone }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Telefone de Emergência 1</label>
                                    <p class="text-base text-gray-900">{{ $patient->emergency_phone_1 }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Nome do Contato de Emergência 1</label>
                                    <p class="text-base text-gray-900">{{ $patient->emergency_contact_1 }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Telefone de Emergência 2</label>
                                    <p class="text-base text-gray-900">{{ $patient->emergency_phone_2 }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Nome do Contato de Emergência 2</label>
                                    <p class="text-base text-gray-900">{{ $patient->emergency_contact_2 }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-step.items>

                <!-- Step 3: Informações Adicionais -->
                <x-step.items step="3" title="Informações Adicionais" description="Dados complementares e histórico de saúde">
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
                                    <p class="text-base text-gray-900">{{ is_array($patient->vices) ? implode(', ', $patient->vices) : $patient->vices }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Transtornos</label>
                                    <p class="text-base text-gray-900">{{ is_array($patient->disorders) ? implode(', ', $patient->disorders) : $patient->disorders }}</p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Histórico de Suicídio na Família</label>
                                    <p class="text-base text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $patient->family_suicide_history ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $patient->family_suicide_history ? 'Sim' : 'Não' }}
                                        </span>
                                    </p>
                                </div>
                                <div class="space-y-1">
                                    <label class="text-sm font-medium text-gray-500">Pensamentos Suicidas</label>
                                    <p class="text-base text-gray-900">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $patient->suicidal_thoughts ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $patient->suicidal_thoughts ? 'Sim' : 'Não' }}
                                        </span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </x-step.items>
            </x-step>
        </x-card>
    </x-modal>
</div>
