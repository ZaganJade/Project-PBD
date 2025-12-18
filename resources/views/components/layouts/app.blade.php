<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'RSHP System') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles

<body
    class="min-h-screen flex flex-col bg-gradient-to-br from-blue-50 via-white to-blue-100 dark:from-zinc-900 dark:via-zinc-800 dark:to-zinc-900 text-gray-900 dark:text-gray-100">

    {{-- @auth
        <div class="bg-blue-900 flex justify-end p-6">
            <div class="flex items-center gap-4">
                <span class="text-white text-sm">👋 {{ auth()->user()->username }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="border border-blue-500 text-white hover:bg-blue-100 hover:border-blue-400 hover:text-blue-600 text-sm px-4 py-2 rounded-lg shadow-sm transition duration-200">
                        Logout
                    </button>

                </form>

            </div>
        </div>
    @endauth --}}

    {{-- 🔸 Konten utama --}}
    <main class="flex-grow w-full">
        {{ $slot }}
    </main>

    {{-- 🔻 Footer sticky di bawah --}}
    <footer class="bg-blue-900 text-blue-100 text-center py-4 rounded-t-2xl shadow-inner">
        <p class="text-sm">&copy; {{ date('Y') }} Marketplace</p>
    </footer>
    @livewireScripts
</body>

</html>
