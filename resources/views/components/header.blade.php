@props(['title', 'breadcrumbs' => []])

<header class="border-b border-gray-200 dark:border-[#334155] bg-white dark:bg-[#334155] mb-4 rounded-lg shadow-sm">
    <div class="px-4 py-4">
        <div class="flex flex-col space-y-2">
            <!-- Title -->
            <h1 class="text-2xl font-semibold text-gray-900 dark:text-white">{{ $title }}</h1>
            <!-- Breadcrumb -->
            <nav class="flex items-center text-sm">
                <a href="{{ route('dashboard') }}" class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </a>
                @foreach ($breadcrumbs as $breadcrumb)
                    <span class="text-gray-400 dark:text-gray-300 mx-2">/</span>
                    @if (isset($breadcrumb['url']))
                        <a href="{{ $breadcrumb['url'] }}"
                            class="text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-white">{{ $breadcrumb['label'] }}</a>
                    @else
                        <span class="text-gray-900 dark:text-white font-medium">{{ $breadcrumb['label'] }}</span>
                    @endif
                @endforeach
            </nav>
        </div>
    </div>
</header>
