<?php

namespace App\Http\Controllers;

use App\Models\Episode;

class RssController extends Controller
{
    public function __invoke()
    {
        $episodes = Episode::published()->newest()->limit(300)->get();

        $feed = view('rss.feed', [
            'episodes' => $episodes,
            'podcast'  => config('podcast'),
            'link'     => url('/'),
            'feedUrl'  => url('/feed.rss'),
        ])->render();

        return response($feed, 200, [
            'Content-Type'  => 'application/rss+xml; charset=UTF-8',
            'Cache-Control' => 'public, max-age=3600',
        ]);
    }
}
