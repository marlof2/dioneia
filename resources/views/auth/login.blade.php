<x-guest-layout>
    <div class="flex items-center justify-center">
        <img src="{{ asset('/assets/images/logo2.png') }}" width="80%" height="50%" />
    </div>

    <div class="flex items-center justify-center mb-5">
        <h1 class="text-2 font-bold">Faça login para continuar</h1>
    </div>


    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="space-y-4">
            <x-input label="Email *" type="email" name="email" :value="old('email', 'marlosilva.f2@gmail.com')" required autofocus
                autocomplete="username" />

            <x-password label="Password *" type="password" name="password" :value="old('password', '123')" required
                autocomplete="current-password" />
        </div>


        <div class="flex items-center justify-center mt-4">

            <x-button type="submit" class="w-full">
                {{ __('Entrar') }}
            </x-button>
        </div>

    </form>
</x-guest-layout>
