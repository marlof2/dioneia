<div>
    <x-header title="{{ $title }}" :breadcrumbs="[['label' => 'Pacientes', 'url' => route('patients.index')], ['label' => $title]]" />
    <x-card bordered>
        <form wire:submit="save">
            <x-step wire:model="currentStep" helpers navigate navigate-previous class="mb-10">
                <hr style="color: gray">
                <!-- Step 1: Dados Pessoais -->
                <x-step.items step="1" title="Dados Pessoais" description="Informações básicas do paciente">
                    <div class="space-y-4 mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-input label="Nome Completo *" wire:model="form.name" />
                            <x-input label="CPF *" wire:model="form.cpf" x-mask="999.999.999-99" />
                            <x-input type="date" label="Data de Nascimento *" wire:model="form.birth_date"
                                wire:blur="calculateAge" />
                            <x-input type="number" label="Idade *" wire:model="form.age" disabled />
                            <x-input label="Nome da Mãe" wire:model="form.mother_name" />
                            <x-input label="Nome do Pai" wire:model="form.father_name" />
                            <x-input label="Responsável Legal" wire:model="form.legal_guardian" />
                            <x-select.styled label="Gênero *" wire:model="form.gender" :options="$optionsGender"
                                placeholder="Selecione o gênero" />
                            <x-select.styled label="Estado Civil *" wire:model="form.marital_status" :options="$optionsMaritalStatus"
                                placeholder="Selecione o estado civil" />
                            <x-input type="number" label="Número de Filhos" wire:model="form.children" />
                        </div>
                        @if(request()->routeIs('patients.edit'))
                            <div class="flex justify-center mt-6">
                                <x-button type="submit" size="lg">
                                    Salvar Paciente
                                </x-button>
                            </div>
                        @endif
                    </div>
                </x-step.items>

                <!-- Step 2: Histórico Familiar -->
                <x-step.items step="2" title="Histórico Familiar"
                    description="Informações sobre o histórico familiar do paciente">
                    <div class="space-y-6 mt-6">
                        <div class="space-y-4">
                            <x-checkbox label="Histórico de Suicídio na Família"
                                wire:model="form.family_suicide_history" />
                            <x-textarea label="Histórico de Saúde Mental na Família" wire:model="form.family_mental_health_history"
                                placeholder="Descreva o histórico de saúde mental na família" rows="4" />
                            <x-textarea label="Eventos Significativos na Família" wire:model="form.family_significant_events"
                                placeholder="Descreva os eventos significativos na família" rows="4" />
                            @if(request()->routeIs('patients.edit'))
                                <div class="flex justify-center mt-6">
                                    <x-button type="submit" size="lg">
                                        Salvar Paciente
                                    </x-button>
                                </div>
                            @endif
                        </div>
                    </div>
                </x-step.items>

                <!-- Step 3: Endereço e Contato -->
                <x-step.items step="3" title="Endereço e Contato"
                    description="Informações de localização e contato">
                    <div class="space-y-4 mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-input label="Endereço *" wire:model="form.address" />
                            <x-input label="Cidade *" wire:model="form.city" />
                            <x-input label="Telefone Principal *" wire:model="form.phone" x-mask="(99) 99999-9999" />
                            <x-input label="Telefone de Emergência 1" wire:model="form.emergency_phone_1"
                                x-mask="(99) 99999-9999" />
                            <x-input label="Nome do Contato de Emergência 1" wire:model="form.emergency_contact_1" />
                            <x-input label="Telefone de Emergência 2" wire:model="form.emergency_phone_2"
                                x-mask="(99) 99999-9999" />
                            <x-input label="Nome do Contato de Emergência 2" wire:model="form.emergency_contact_2" />
                        </div>
                        @if(request()->routeIs('patients.edit'))
                            <div class="flex justify-center mt-6">
                                <x-button type="submit" size="lg">
                                    Salvar Paciente
                                </x-button>
                            </div>
                        @endif
                    </div>
                </x-step.items>

                <!-- Step 4: Informações Adicionais -->
                <x-step.items step="4" title="Informações Adicionais"
                    description="Dados complementares">
                    <div class="space-y-6 mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-input label="Religião" wire:model="form.religion" />
                            <x-select.styled label="Nível de Escolaridade *" wire:model="form.education_level"
                                :options="$optionsEducationLevel" placeholder="Selecione o nível de escolaridade" />
                            <x-input label="Ocupação *" wire:model="form.occupation" />
                        </div>
                        <div class="space-y-4">
                            <x-textarea label="Vícios" wire:model="form.vices" />
                            <x-textarea label="Transtornos" wire:model="form.disorders"
                                placeholder="Descreva os transtornos do paciente" rows="4" />
                            <x-textarea label="Tem ou teve ideação suicida" wire:model="form.suicidal_ideation"
                                placeholder="Descreva se o paciente tem ou teve ideação suicida" rows="4" />
                            <x-input type="date" label="Data da Finalização" wire:model="form.completion_date" />
                            <x-textarea label="Observação da Finalização" wire:model="form.completion_notes"
                                placeholder="Descreva as observações da finalização" rows="4" />
                        </div>
                        @if(request()->routeIs('patients.edit'))
                            <div class="flex justify-center mt-6">
                                <x-button type="submit" size="lg">
                                    Salvar Paciente
                                </x-button>
                            </div>
                        @endif
                    </div>
                </x-step.items>

                <!-- Step 5: Encaminhamentos -->
                <x-step.items step="5" title="Encaminhamentos"
                    description="Informações sobre encaminhamentos do paciente">
                    <div class="space-y-6 mt-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-input type="date" label="Data do Encaminhamento" wire:model="form.referral_date" />
                            <x-input type="date" label="Data de Retorno" wire:model="form.referral_return_date" />
                            <x-input label="Profissional" wire:model="form.referral_professional" />
                            <x-input label="Especialidade" wire:model="form.referral_specialty" />
                            <x-input label="Instituição" wire:model="form.referral_institution" />
                        </div>
                        <div class="space-y-4">
                            <x-textarea label="Motivo do Encaminhamento" wire:model="form.referral_reason"
                                placeholder="Breve justificativa do encaminhamento" rows="4" />
                        </div>
                        @if(request()->routeIs('patients.edit'))
                            <div class="flex justify-center mt-6">
                                <x-button type="submit" size="lg">
                                    Salvar Paciente
                                </x-button>
                            </div>
                        @endif
                    </div>
                </x-step.items>

                @unless(request()->routeIs('patients.edit'))
                    <x-slot:finish>
                        <div class="flex justify-center mt-6">
                            <x-button type="submit" size="lg">
                                Salvar Paciente
                            </x-button>
                        </div>
                    </x-slot:finish>
                @endunless
            </x-step>
        </form>
        <x-toast />
    </x-card>
</div>
