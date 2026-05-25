<?php

namespace Tests\Feature;

use App\Models\Episode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EpisodeShowTest extends TestCase
{
    use RefreshDatabase;

    public function test_published_episode_is_visible(): void
    {
        $episode = Episode::factory()->create(['published_at' => now()->subDay()]);

        $this->get("/episodes/{$episode->slug}")->assertStatus(200)->assertSee($episode->title);
    }

    public function test_draft_episode_returns_404(): void
    {
        $episode = Episode::factory()->create(['published_at' => null]);

        $this->get("/episodes/{$episode->slug}")->assertStatus(404);
    }

    public function test_future_episode_returns_404(): void
    {
        $episode = Episode::factory()->create(['published_at' => now()->addDay()]);

        $this->get("/episodes/{$episode->slug}")->assertStatus(404);
    }

    public function test_episode_page_shows_title_and_description(): void
    {
        $episode = Episode::factory()->create([
            'title' => 'Donut Is Best Cat',
            'description' => 'We discuss Donut at length.',
            'published_at' => now()->subDay(),
        ]);

        $this->get("/episodes/{$episode->slug}")
            ->assertSee('Donut Is Best Cat')
            ->assertSee('We discuss Donut at length.');
    }

    public function test_episode_page_shows_show_notes_when_present(): void
    {
        $episode = Episode::factory()->create([
            'show_notes' => 'Links mentioned in this episode.',
            'published_at' => now()->subDay(),
        ]);

        $this->get("/episodes/{$episode->slug}")->assertSee('Links mentioned in this episode.');
    }

    public function test_episode_page_omits_show_notes_section_when_empty(): void
    {
        $episode = Episode::factory()->create([
            'show_notes' => null,
            'published_at' => now()->subDay(),
        ]);

        $this->get("/episodes/{$episode->slug}")->assertDontSee('SHOW NOTES');
    }
}
