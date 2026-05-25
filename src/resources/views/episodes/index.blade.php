@extends('layouts.app')

@section('title', 'Episodes')

@section('content')
<div class="mb-10 -mx-4 -mt-8">
    <img src="{{ asset('images/title-banner.jpg') }}"
         alt="Crawler in Waiting — A Dungeon Crawler Carl Read-Along Podcast"
         class="w-full object-cover object-top">
</div>

<div class="mb-8">
    <h1 class="text-2xl font-bold text-amber-400 tracking-wide">EPISODE LOG</h1>
    <p class="text-stone-500 text-sm mt-1">All transmissions from the dungeon, catalogued.</p>
</div>

@if($episodes->isEmpty())
    <div class="text-center py-20 text-stone-600">
        <div class="text-4xl mb-4">⚔</div>
        <p>No episodes yet. The crawl begins soon.</p>
    </div>
@else
    <div class="space-y-4">
        @foreach($episodes as $episode)
        <a href="{{ route('episodes.show', $episode) }}"
           class="block border border-stone-800 hover:border-amber-800/60 bg-stone-900/50 hover:bg-stone-900 rounded p-5 transition-all group">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-3 mb-1">
                        <span class="text-xs text-amber-700 font-bold tracking-widest">{{ $episode->episode_label }}</span>
                        <span class="text-xs text-stone-600">{{ $episode->published_at->format('M j, Y') }}</span>
                    </div>
                    <h2 class="text-stone-100 font-semibold group-hover:text-amber-300 transition-colors truncate">
                        {{ $episode->title }}
                    </h2>
                    <p class="text-stone-500 text-sm mt-1 line-clamp-2">{{ $episode->description }}</p>
                </div>
                <div class="text-stone-600 text-sm shrink-0 pt-1">{{ $episode->duration_formatted }}</div>
            </div>
        </a>
        @endforeach
    </div>

    <div class="mt-8">
        {{ $episodes->links() }}
    </div>
@endif
@endsection
