<div>
    <x-modal :title="__('Atualizar Usuário: #:id', ['id' => $user?->id])" wire>
        <form id="user-update-{{ $user?->id }}" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('Nome') }} *" wire:model="user.name" required />
            </div>

            <div>
                <x-input label="{{ __('Email') }} *" wire:model="user.email" required />
            </div>

            <div>
                <x-password :label="__('Senha')"
                            hint="A senha será atualizada apenas se você definir o valor deste campo"
                            wire:model="password"
                            rules
                            generator
                            x-on:generate="$wire.set('password_confirmation', $event.detail.password)" />
            </div>

            <div>
                <x-password :label="__('Confirmar senha')" wire:model="password_confirmation" rules />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="user-update-{{ $user?->id }}">
                @lang('Salvar')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
