<?php

namespace App\Http\Controllers;

use App\Models\Episode;

class EpisodeController extends Controller
{
    public function index()
    {
        $episodes = Episode::published()->newest()->paginate(12);

        return view('episodes.index', compact('episodes'));
    }

    public function show(Episode $episode)
    {
        abort_unless($episode->published_at && $episode->published_at <= now(), 404);

        return view('episodes.show', compact('episode'));
    }
}
