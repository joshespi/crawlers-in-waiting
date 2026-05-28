@extends('layouts.app')

@section('title', 'About')

@section('content')
    <div>
        <h1 class="text-2xl font-bold text-amber-400 tracking-wide mb-8">ABOUT THE SHOW</h1>

        <div class="flex gap-8 items-start mb-10">
            <img src="{{ asset('images/album.jpg') }}" alt="{{ config('podcast.title') }}"
                class="rounded-lg object-cover ring-1 ring-stone-700 shrink-0 self-start"
                style="width:200px;height:250px;min-width:250px;">
            <div class="space-y-4 text-stone-400 leading-relaxed">
                <p>
                    The apocalypse came. The dungeon opened. We were not chosen.
                    We're just crawlers in waiting — standing by while Carl figures it out.
                </p>
                <p>
                    <span class="text-stone-200 font-semibold">Crawlers in Waiting</span> is a
                    read-along podcast for the Dungeon Crawler Carl series by Matt Dinniman.
                    We read the books alongside you — chapter by chapter, floor by floor —
                    and talk through everything: the lore, the mechanics, the callbacks,
                    and all the ways Carl keeps somehow not dying.
                </p>
                <p>
                    If you haven't started the series yet: go read it.
                    We'll be here when you catch up.
                </p>
            </div>
        </div>

        <div class="space-y-6 text-stone-400 leading-relaxed">

            <div class="border border-stone-800 rounded p-5 mt-8">
                <div class="text-xs text-stone-600 font-bold tracking-widest mb-4">YOUR HOSTS</div>
                <div class="flex flex-wrap gap-6">
                    @foreach ([['espi', 'Espi'], ['skys', 'Skys'], ['grish', 'Grish']] as [$slug, $name])
                        <div class="flex flex-col items-center gap-2">
                            <img src="{{ asset('images/' . $slug . '.jpg') }}" alt="{{ $name }}"
                                class="w-20 h-20 rounded-full object-cover ring-1 ring-stone-700" />
                            <span class="text-sm text-stone-300 font-semibold">{{ $name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="border border-stone-800 rounded p-5 mt-4">
                <div class="text-xs text-stone-600 font-bold tracking-widest mb-3">FIND US</div>
                <ul class="space-y-2 text-sm">
                    <li>
                        <a href="{{ route('rss') }}" class="text-amber-500 hover:text-amber-300 transition-colors">RSS
                            Feed</a>
                        <span class="text-stone-600 ml-2">— add to any podcast app</span>
                    </li>
                    @foreach (array_filter(['Facebook' => config('social.facebook'), 'Twitter' => config('social.twitter'), 'Instagram' => config('social.instagram')]) as $label => $url)
                        <li><a href="{{ $url }}" target="_blank" rel="noopener"
                                class="text-amber-500 hover:text-amber-300 transition-colors">{{ $label }}</a></li>
                    @endforeach
                </ul>
            </div>

            <div class="border border-stone-800 rounded p-5">
                <div class="text-xs text-stone-600 font-bold tracking-widest mb-3">DISCLAIMER</div>
                <p class="text-sm text-stone-600">
                    Crawlers in Waiting is a fan production. Dungeon Crawler Carl and all related
                    characters, lore, and world-building are the intellectual property of Matt Dinniman.
                    We just really like the books.
                </p>
            </div>
        </div>
    </div>

@endsection
