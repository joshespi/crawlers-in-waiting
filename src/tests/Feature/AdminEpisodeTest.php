<?php

namespace Tests\Feature;

use App\Models\Episode;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminEpisodeTest extends TestCase
{
    use RefreshDatabase;

    private User $admin;

    protected function setUp(): void
    {
        parent::setUp();
        $this->admin = User::factory()->create();
    }

    public function test_episode_list_requires_auth(): void
    {
        $this->get(route('admin.episodes.index'))->assertRedirect('/login');
    }

    public function test_episode_list_shows_all_episodes(): void
    {
        Episode::factory()->create(['title' => 'Published Ep', 'published_at' => now()->subDay()]);
        Episode::factory()->create(['title' => 'Draft Ep', 'published_at' => null]);

        $this->actingAs($this->admin)
            ->get(route('admin.episodes.index'))
            ->assertSee('Published Ep')
            ->assertSee('Draft Ep');
    }

    public function test_create_form_loads(): void
    {
        $this->actingAs($this->admin)
            ->get(route('admin.episodes.create'))
            ->assertStatus(200);
    }

    public function test_can_create_episode(): void
    {
        $this->actingAs($this->admin)->post(route('admin.episodes.store'), [
            'episode_number'  => 1,
            'season_number'   => 1,
            'title'           => 'First Episode',
            'description'     => 'The beginning.',
            'audio_url'       => 'https://cdn.example.com/ep1.mp3',
            'duration_seconds' => 2400,
            'published_at'    => null,
        ])->assertRedirect(route('admin.episodes.index'));

        $this->assertDatabaseHas('episodes', ['slug' => 'first-episode']);
    }

    public function test_slug_auto_generated_from_title(): void
    {
        $this->actingAs($this->admin)->post(route('admin.episodes.store'), [
            'episode_number'  => 1,
            'season_number'   => 1,
            'title'           => 'Hello World Episode',
            'description'     => 'Test.',
            'audio_url'       => 'https://cdn.example.com/ep.mp3',
            'duration_seconds' => 1000,
        ]);

        $this->assertDatabaseHas('episodes', ['slug' => 'hello-world-episode']);
    }

    public function test_slug_deduped_when_title_collision(): void
    {
        Episode::factory()->create(['slug' => 'duplicate-title']);

        $this->actingAs($this->admin)->post(route('admin.episodes.store'), [
            'episode_number'  => 2,
            'season_number'   => 1,
            'title'           => 'Duplicate Title',
            'description'     => 'Dupe.',
            'audio_url'       => 'https://cdn.example.com/ep2.mp3',
            'duration_seconds' => 1800,
        ])->assertRedirect(route('admin.episodes.index'));

        $this->assertDatabaseHas('episodes', ['slug' => 'duplicate-title-2']);
    }

    public function test_can_update_episode(): void
    {
        $episode = Episode::factory()->create(['title' => 'Old Title']);

        $this->actingAs($this->admin)->put(route('admin.episodes.update', $episode), [
            'episode_number'  => $episode->episode_number,
            'season_number'   => $episode->season_number,
            'title'           => 'New Title',
            'description'     => $episode->description,
            'audio_url'       => $episode->audio_url,
            'duration_seconds' => $episode->duration_seconds,
        ])->assertRedirect(route('admin.episodes.index'));

        $this->assertDatabaseHas('episodes', ['id' => $episode->id, 'title' => 'New Title']);
    }

    public function test_can_save_youtube_url(): void
    {
        $this->actingAs($this->admin)->post(route('admin.episodes.store'), [
            'episode_number'  => 1,
            'season_number'   => 1,
            'title'           => 'YouTube Episode',
            'description'     => 'Has video.',
            'audio_url'       => 'https://archive.org/ep.mp3',
            'youtube_url'     => 'https://www.youtube.com/watch?v=abc123',
            'duration_seconds' => 3600,
        ])->assertRedirect(route('admin.episodes.index'));

        $this->assertDatabaseHas('episodes', ['youtube_url' => 'https://www.youtube.com/watch?v=abc123']);
    }

    public function test_can_delete_episode(): void
    {
        $episode = Episode::factory()->create();

        $this->actingAs($this->admin)
            ->delete(route('admin.episodes.destroy', $episode))
            ->assertRedirect(route('admin.episodes.index'));

        $this->assertDatabaseMissing('episodes', ['id' => $episode->id]);
    }
}
