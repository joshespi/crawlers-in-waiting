@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-lg font-bold text-stone-200 tracking-wide">Profile</h1>
</div>

<form method="POST" action="{{ route('admin.profile.update') }}" class="space-y-6 max-w-2xl">
    @csrf
    @method('PUT')

    <div>
        <label class="block text-xs text-stone-500 mb-1 tracking-widest">NAME</label>
        <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required
            class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none @error('name') border-red-700 @enderror">
        @error('name') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs text-stone-500 mb-1 tracking-widest">EMAIL</label>
        <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required
            class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none @error('email') border-red-700 @enderror">
        @error('email') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="border-t border-stone-800 pt-6">
        <p class="text-xs text-stone-600 mb-4 tracking-widest">CHANGE PASSWORD — leave blank to keep current</p>

        <div class="space-y-4">
            <div>
                <label class="block text-xs text-stone-500 mb-1 tracking-widest">NEW PASSWORD</label>
                <input type="password" name="password"
                    class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none @error('password') border-red-700 @enderror">
                @error('password') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-xs text-stone-500 mb-1 tracking-widest">CONFIRM PASSWORD</label>
                <input type="password" name="password_confirmation"
                    class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none">
            </div>
        </div>
    </div>

    <div class="pt-2">
        <button type="submit"
            class="bg-amber-800 hover:bg-amber-700 text-amber-100 font-bold px-6 py-2 rounded text-sm tracking-wide transition-colors">
            Save Changes
        </button>
    </div>
</form>
@endsection
