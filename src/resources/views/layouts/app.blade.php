<!DOCTYPE html>
<html lang="en" class="bg-stone-950 text-stone-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Crawlers in Waiting') — A DCC Read-Along Podcast</title>
    <meta name="description" content="@yield('description', 'A Dungeon Crawler Carl read-along podcast.')">
    <meta property="og:title" content="@yield('title', 'Crawlers in Waiting')">
    <meta property="og:description" content="@yield('description', 'A Dungeon Crawler Carl read-along podcast.')">
    <meta property="og:image" content="{{ asset('images/album.jpg') }}">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:type" content="website">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:image" content="{{ asset('images/album.jpg') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col font-mono">

    <header class="border-b border-amber-900/40 bg-stone-950/90 sticky top-0 z-10 backdrop-blur">
        <div class="max-w-4xl mx-auto px-4 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="group flex items-center gap-3">
                <span class="text-amber-500 text-xl">⚔</span>
                <div>
                    <div class="text-amber-400 font-bold text-lg leading-tight tracking-wide">CRAWLERS IN WAITING</div>
                    <div class="text-stone-500 text-xs">A Dungeon Crawler Carl Read-Along Podcast</div>
                </div>
            </a>
            <nav class="flex gap-6 text-sm text-stone-400">
                <a href="{{ route('home') }}" class="hover:text-amber-400 transition-colors">Episodes</a>
                <a href="{{ route('about') }}" class="hover:text-amber-400 transition-colors">About</a>
                <a href="{{ route('rss') }}" class="hover:text-amber-400 transition-colors" title="RSS Feed">RSS</a>
            </nav>
        </div>
    </header>

    <main class="flex-1 max-w-4xl mx-auto w-full px-4 py-8">
        @if(session('success'))
            <div class="mb-6 px-4 py-3 bg-amber-900/30 border border-amber-700/50 text-amber-300 text-sm rounded">
                {{ session('success') }}
            </div>
        @endif

        @yield('content')
    </main>

    <footer class="border-t border-stone-800 mt-auto">
        <div class="max-w-4xl mx-auto px-4 py-6 text-center text-stone-600 text-xs space-y-2">
            @include('partials.social-links')
            <p>Crawlers in Waiting is a fan podcast. Dungeon Crawler Carl is created by Matt Dinniman.</p>
            <p><a href="{{ route('rss') }}" class="hover:text-amber-500 transition-colors">RSS Feed</a></p>
        </div>
    </footer>

</body>
</html>
