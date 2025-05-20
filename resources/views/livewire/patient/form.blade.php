<div>
    <x-card>
        <x-slot:header>
            <h1 class="text-2xl font-bold">Novo Paciente</h1>
        </x-slot:header>

        <form wire:submit="save">
            <x-step wire:model="currentStep" helpers navigate-previous >
                <hr style="color: gray">
                <!-- Step 1: Dados Pessoais -->
                <x-step.items step="1" title="Dados Pessoais" description="Informações básicas do paciente">
                    <div class="space-y-4 mt-6">
                        <x-input label="Nome Completo *" wire:model="form.name" />
                        <x-input type="date" label="Data de Nascimento *" wire:model="form.birth_date"
                            wire:blur="calculateAge" />
                        <x-input type="number" label="Idade *" wire:model="form.age" disabled />
                        <x-select.styled label="Gênero *" wire:model="form.gender" :options="$optionsGender"
                            placeholder="Selecione o gênero" />
                        <x-select.styled label="Estado Civil *" wire:model="form.marital_status" :options="$optionsMaritalStatus"
                            placeholder="Selecione o estado civil" />
                        <x-input type="number" label="Número de Filhos" wire:model="form.children" />
                    </div>
                </x-step.items>

                <!-- Step 2: Endereço e Contato -->
                <x-step.items step="2" title="Endereço e Contato"
                    description="Informações de localização e contato">
                    <div class="space-y-4 mt-6">
                        <x-input label="Endereço *" wire:model="form.address" />
                        <x-input label="Cidade *" wire:model="form.city" />
                        <x-input label="Telefone Principal *" wire:model="form.phone" />
                        <x-input label="Telefone de Emergência 1" wire:model="form.emergency_phone_1" />
                        <x-input label="Nome do Contato de Emergência 1" wire:model="form.emergency_contact_1" />
                        <x-input label="Telefone de Emergência 2" wire:model="form.emergency_phone_2" />
                        <x-input label="Nome do Contato de Emergência 2" wire:model="form.emergency_contact_2" />
                    </div>
                </x-step.items>

                <!-- Step 3: Informações Adicionais -->
                <x-step.items step="3" title="Informações Adicionais"
                    description="Dados complementares e histórico de saúde">
                    <div class="space-y-6 mt-6">
                        <div class="space-y-4">
                            <x-input label="Religião" wire:model="form.religion" />
                            <x-select.styled label="Nível de Escolaridade *" wire:model="form.education_level"
                                :options="$optionsEducationLevel" placeholder="Selecione o nível de escolaridade" />
                            <x-input label="Ocupação *" wire:model="form.occupation" />
                            <x-textarea label="Vícios" wire:model="form.vices" />
                            <x-textarea label="Transtornos" wire:model="form.disorders"
                                placeholder="Descreva os transtornos do paciente" rows="4" />
                            <x-checkbox label="Histórico de Suicídio na Família" wire:model="form.family_suicide_history" />
                            <x-checkbox label="Pensamentos Suicidas" wire:model="form.suicidal_thoughts" />
                        </div>
                    </div>
                </x-step.items>

                <x-slot:finish>
                    <div class="flex justify-center mt-6">
                        <x-button type="submit" size="lg">
                            Salvar Paciente
                        </x-button>
                    </div>
                </x-slot:finish>
            </x-step>
        </form>
        <x-toast />
    </x-card>
</div>
