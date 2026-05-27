@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-lg font-bold text-stone-200 tracking-wide">
        {{ $episode->exists ? 'Edit Episode' : 'New Episode' }}
    </h1>
    <a href="{{ route('admin.episodes.index') }}" class="text-stone-500 hover:text-amber-400 text-sm transition-colors">← Back</a>
</div>

<form method="POST"
      action="{{ $episode->exists ? route('admin.episodes.update', $episode) : route('admin.episodes.store') }}"
      class="space-y-6 max-w-2xl">
    @csrf
    @if($episode->exists) @method('PUT') @endif

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs text-stone-500 mb-1 tracking-widest">BOOK</label>
            <input type="number" name="season_number" value="{{ old('season_number', $episode->season_number ?? 1) }}" min="1" required
                class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none @error('season_number') border-red-700 @enderror">
            @error('season_number') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-xs text-stone-500 mb-1 tracking-widest">CHAPTER #</label>
            <input type="number" name="episode_number" value="{{ old('episode_number', $episode->episode_number ?? '') }}" min="0" required
                class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none @error('episode_number') border-red-700 @enderror">
            @error('episode_number') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
    </div>

    <div>
        <label class="block text-xs text-stone-500 mb-1 tracking-widest">TITLE</label>
        <input type="text" name="title" value="{{ old('title', $episode->title ?? '') }}" required
            class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none @error('title') border-red-700 @enderror">
        @error('title') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    @if($episode->exists)
    <div>
        <label class="block text-xs text-stone-500 mb-1 tracking-widest">SLUG</label>
        <input type="text" value="{{ $episode->slug }}" disabled
            class="w-full bg-stone-800 border border-stone-700 rounded px-3 py-2 text-stone-500 text-sm cursor-not-allowed">
        <p class="text-stone-600 text-xs mt-1">Auto-generated on create. Can't change — it's the public URL.</p>
    </div>
    @endif

    <div>
        <label class="block text-xs text-stone-500 mb-1 tracking-widest">DESCRIPTION</label>
        <textarea name="description" rows="3" required
            class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none @error('description') border-red-700 @enderror">{{ old('description', $episode->description ?? '') }}</textarea>
        @error('description') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs text-stone-500 mb-1 tracking-widest">AUDIO URL</label>
        <input type="url" id="audio_url" name="audio_url" value="{{ old('audio_url', $episode->audio_url ?? '') }}" required
            class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none @error('audio_url') border-red-700 @enderror">
        @error('audio_url') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
        <label class="block text-xs text-stone-500 mb-1 tracking-widest">YOUTUBE URL (optional)</label>
        <input type="url" name="youtube_url" value="{{ old('youtube_url', $episode->youtube_url ?? '') }}"
            class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none">
    </div>

    <div class="grid grid-cols-2 gap-4">
        <div>
            <label class="block text-xs text-stone-500 mb-1 tracking-widest">
                DURATION (seconds)
                <span id="duration-status" class="ml-2 normal-case font-normal text-stone-600"></span>
            </label>
            <input type="number" id="duration_seconds" name="duration_seconds" value="{{ old('duration_seconds', $episode->duration_seconds ?? '') }}" min="1" required
                class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none @error('duration_seconds') border-red-700 @enderror">
            @error('duration_seconds') <p class="text-red-400 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="block text-xs text-stone-500 mb-1 tracking-widest">PUBLISH DATE</label>
            <input type="datetime-local" name="published_at"
                value="{{ old('published_at', $episode->published_at ? $episode->published_at->format('Y-m-d\TH:i') : '') }}"
                class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none">
            <p class="text-stone-600 text-xs mt-1">Leave blank to keep as draft.</p>
        </div>
    </div>

    <div>
        <label class="block text-xs text-stone-500 mb-1 tracking-widest">COVER IMAGE URL (optional)</label>
        <input type="url" name="cover_image_url" value="{{ old('cover_image_url', $episode->cover_image_url ?? '') }}"
            class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none">
    </div>

    <div>
        <label class="block text-xs text-stone-500 mb-1 tracking-widest">SHOW NOTES (optional)</label>
        <textarea name="show_notes" rows="8"
            class="w-full bg-stone-900 border border-stone-700 rounded px-3 py-2 text-stone-200 text-sm focus:border-amber-700 focus:outline-none font-mono">{{ old('show_notes', $episode->show_notes ?? '') }}</textarea>
    </div>

    <div class="flex gap-4 pt-2">
        <button type="submit"
            class="bg-amber-800 hover:bg-amber-700 text-amber-100 font-bold px-6 py-2 rounded text-sm tracking-wide transition-colors">
            {{ $episode->exists ? 'Update Episode' : 'Create Episode' }}
        </button>
        <a href="{{ route('admin.episodes.index') }}"
           class="text-stone-500 hover:text-stone-300 text-sm py-2 transition-colors">Cancel</a>
    </div>
</form>

<script>
(function () {
    const audioInput = document.getElementById('audio_url');
    const durationInput = document.getElementById('duration_seconds');
    const status = document.getElementById('duration-status');
    let audio = null;

    function onMetadata() {
        const secs = Math.round(audio.duration);
        if (isFinite(secs) && secs > 0) {
            durationInput.value = secs;
            status.textContent = '✓ auto-detected';
            status.className = 'ml-2 normal-case font-normal text-amber-600';
        } else {
            onError();
        }
    }

    function onError() {
        status.textContent = 'could not detect — enter manually';
        status.className = 'ml-2 normal-case font-normal text-stone-500';
    }

    function detect(url) {
        if (!url) return;
        status.textContent = 'detecting…';
        if (audio) {
            audio.removeEventListener('loadedmetadata', onMetadata);
            audio.removeEventListener('error', onError);
            audio.src = '';
        }
        audio = new Audio();
        audio.preload = 'metadata';
        audio.addEventListener('loadedmetadata', onMetadata);
        audio.addEventListener('error', onError);
        audio.src = url;
    }

    audioInput.addEventListener('change', function () {
        detect(this.value.trim());
    });

    // Only fires if duration wasn't already filled by the change event
    audioInput.addEventListener('blur', function () {
        if (!durationInput.value) detect(this.value.trim());
    });
}());
</script>
@endsection
