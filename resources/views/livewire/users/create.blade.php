<div>
    <x-button :text="__('Novo Usuário')" wire:click="$toggle('modal')" />

    <x-modal :title="__('Novo Usuário')" wire x-on:open="setTimeout(() => $refs.name.focus(), 250)">
        <form id="user-create" wire:submit="save" class="space-y-4">
            <div>
                <x-input label="{{ __('Nome') }} *" x-ref="name" wire:model="user.name" required />
            </div>

            <div>
                <x-input label="{{ __('Email') }} *" wire:model="user.email" required />
            </div>

            <div>
                <x-password label="{{ __('Password') }} *"
                            wire:model="password"
                            rules
                            generator
                            x-on:generate="$wire.set('password_confirmation', $event.detail.password)"
                            required />
            </div>

            <div>
                <x-password :label="__('Password')" wire:model="password_confirmation" rules required />
            </div>
        </form>
        <x-slot:footer>
            <x-button type="submit" form="user-create">
                @lang('Save')
            </x-button>
        </x-slot:footer>
    </x-modal>
</div>
