@extends('layouts.app')

@section('title', $episode->title)
@section('description', $episode->description)

@section('content')
<div class="mb-6">
    <a href="{{ route('home') }}" class="text-stone-500 hover:text-amber-400 text-sm transition-colors">← All Episodes</a>
</div>

<article>
    <header class="mb-8">
        <div class="flex gap-6 items-start">
            <img src="{{ $episode->cover_image_url ?? asset('images/album.jpg') }}"
                 alt="{{ $episode->title }}"
                 class="w-32 h-32 rounded-lg object-cover ring-1 ring-stone-700 shrink-0">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3 mb-3">
                    <span class="text-xs text-amber-700 font-bold tracking-widest border border-amber-900/50 px-2 py-0.5 rounded">
                        {{ $episode->episode_label }}
                    </span>
                    <span class="text-xs text-stone-600">{{ $episode->published_at->format('F j, Y') }}</span>
                    <span class="text-xs text-stone-600">{{ $episode->duration_formatted }}</span>
                </div>
                <h1 class="text-2xl font-bold text-amber-400">{{ $episode->title }}</h1>
                <p class="text-stone-400 mt-3 leading-relaxed">{{ $episode->description }}</p>
            </div>
        </div>
    </header>

    <div class="mb-8">
        <audio controls class="w-full" preload="metadata">
            <source src="{{ $episode->audio_url }}" type="audio/mpeg">
            Your browser doesn't support HTML5 audio.
        </audio>
    </div>

    @if($episode->show_notes)
    <section class="border-t border-stone-800 pt-8">
        <h2 class="text-sm font-bold text-stone-400 tracking-widest mb-4">SHOW NOTES</h2>
        <div class="text-stone-400 leading-relaxed text-sm whitespace-pre-line">{{ $episode->show_notes }}</div>
    </section>
    @endif
</article>
@endsection
