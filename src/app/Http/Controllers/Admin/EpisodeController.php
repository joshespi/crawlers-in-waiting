<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Episode;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        $data = $this->validated($request, $episode);

        $episode->update($data);

        return redirect()->route('admin.episodes.index')
            ->with('success', 'Episode updated.');
    }

    public function destroy(Episode $episode)
    {
        $episode->delete();

        return redirect()->route('admin.episodes.index')
            ->with('success', 'Episode deleted.');
    }

    private function validated(Request $request, ?Episode $episode = null): array
    {
        $data = $request->validate([
            'episode_number' => 'required|integer|min:1',
            'season_number' => 'required|integer|min:1',
            'title' => 'required|string|max:255',
            'slug' => ['required', 'string', 'max:255', Rule::unique('episodes', 'slug')->ignore($episode)],
            'description' => 'required|string',
            'show_notes' => 'nullable|string',
            'audio_url' => 'required|url',
            'duration_seconds' => 'required|integer|min:1',
            'cover_image_url' => 'nullable|url',
            'published_at' => 'nullable|date',
        ]);

        return $data;
    }
}
