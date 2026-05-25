<!DOCTYPE html>
<html lang="en" class="bg-stone-950 text-stone-200">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Crawlers in Waiting</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center font-mono">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="text-amber-500 text-3xl mb-2">⚔</div>
            <div class="text-amber-400 font-bold tracking-wide">CRAWLERS IN WAITING</div>
            <div class="text-stone-600 text-xs mt-1">Admin Access</div>
        </div>

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block text-xs text-stone-500 mb-1 tracking-widest">EMAIL</label>
                <input type="email" name="email" value="{{ old('email') }}" required autofocus
                    class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none focus:ring-1 focus:ring-amber-700/50 @error('email') border-red-700 @enderror">
                @error('email')
                    <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label class="block text-xs text-stone-500 mb-1 tracking-widest">PASSWORD</label>
                <input type="password" name="password" required
                    class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none focus:ring-1 focus:ring-amber-700/50">
            </div>

            <button type="submit"
                class="w-full bg-amber-800 hover:bg-amber-700 text-amber-100 font-bold py-2 rounded text-sm tracking-wide transition-colors mt-2">
                ENTER THE DUNGEON
            </button>
        </form>
    </div>
</body>
</html>
