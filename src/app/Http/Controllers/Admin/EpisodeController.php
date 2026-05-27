<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use Illuminate\Http\Request;

class EpisodeController extends Controller
{
    public function index()
    {
        $episodes = Episode::orderBy('season_number', 'desc')
            ->orderBy('episode_number', 'desc')
            ->paginate(20);

        return view('admin.episodes.index', compact('episodes'));
    }

    public function create()
    {
        return view('admin.episodes.form', ['episode' => new Episode]);
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = Episode::uniqueSlug($data['title']);

        Episode::create($data);

        return redirect()->route('admin.episodes.index')
            ->with('success', 'Episode created.');
    }

    public function edit(Episode $episode)
    {
        return view('admin.episodes.form', compact('episode'));
    }

    public function update(Request $request, Episode $episode)
    {
        $episode->update($this->validated($request));

        return redirect()->route('admin.episodes.index')
            ->with('success', 'Episode updated.');
    }

    public function destroy(Episode $episode)
    {
        $episode->delete();

        return redirect()->route('admin.episodes.index')
            ->with('success', 'Episode deleted.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'episode_number'  => 'required|integer|min:0',
            'season_number'   => 'required|integer|min:1',
            'title'           => 'required|string|max:255',
            'description'     => 'required|string',
            'show_notes'      => 'nullable|string',
            'audio_url'       => 'required|url|starts_with:https://,http://',
            'youtube_url'     => 'nullable|url|starts_with:https://,http://',
            'duration_seconds' => 'required|integer|min:1',
            'cover_image_url' => 'nullable|url|starts_with:https://,http://',
            'published_at'    => 'nullable|date',
        ]);
    }
}
