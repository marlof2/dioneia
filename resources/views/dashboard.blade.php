<x-app-layout>
    <x-card>
        <x-slot:header>
            <h1 class="text-2xl font-bold">Dashboard</h1>
        </x-slot:header>
        <div class="space-y-2">
            <p>
                👋🏻 Bem vindo {{ auth()->user()->name }}!
            </p>
        </div>
    </x-card>
</x-app-layout>
