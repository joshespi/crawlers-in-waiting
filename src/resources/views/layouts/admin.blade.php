<!DOCTYPE html>
<html lang="en" class="bg-stone-950 text-stone-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin — Crawlers in Waiting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col font-mono">

    <header class="border-b border-stone-700 bg-stone-900">
        <div class="max-w-5xl mx-auto px-4 py-3 flex items-center justify-between">
            <div class="text-amber-400 font-bold text-sm tracking-wide">CIW ADMIN</div>
            <div class="flex items-center gap-6 text-sm">
                <a href="{{ route('admin.episodes.index') }}" class="text-stone-400 hover:text-amber-400 transition-colors">Episodes</a>
                <a href="{{ route('admin.profile.edit') }}" class="text-stone-400 hover:text-amber-400 transition-colors">Profile</a>
                <a href="{{ route('home') }}" class="text-stone-400 hover:text-amber-400 transition-colors">View Site</a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="text-stone-500 hover:text-red-400 transition-colors text-sm">Logout</button>
                </form>
            </div>
        </div>
    </header>

    <main class="flex-1 max-w-5xl mx-auto w-full px-4 py-8">
        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-amber-900/30 border border-amber-700/50 text-amber-300 text-sm rounded">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

</body>
</html>
