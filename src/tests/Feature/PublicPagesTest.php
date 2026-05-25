<?php

namespace Tests\Feature;

use App\Models\Episode;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_loads(): void
    {
        $this->get('/')->assertStatus(200);
    }

    public function test_home_page_shows_published_episodes(): void
    {
        $episode = Episode::factory()->create([
            'title' => 'Floor One Problems',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/')->assertSee('Floor One Problems');
    }

    public function test_home_page_hides_draft_episodes(): void
    {
        Episode::factory()->create([
            'title' => 'Secret Draft',
            'published_at' => null,
        ]);

        $this->get('/')->assertDontSee('Secret Draft');
    }

    public function test_home_page_hides_future_episodes(): void
    {
        Episode::factory()->create([
            'title' => 'Not Yet',
            'published_at' => now()->addDay(),
        ]);

        $this->get('/')->assertDontSee('Not Yet');
    }

    public function test_about_page_loads(): void
    {
        $this->get('/about')->assertStatus(200);
    }

    public function test_rss_feed_returns_xml(): void
    {
        $this->get('/feed.rss')
            ->assertStatus(200)
            ->assertHeader('Content-Type', 'application/rss+xml; charset=UTF-8');
    }

    public function test_rss_feed_includes_published_episode(): void
    {
        $episode = Episode::factory()->create([
            'title' => 'Carl Hits Floor One',
            'published_at' => now()->subDay(),
        ]);

        $this->get('/feed.rss')->assertSee('Carl Hits Floor One');
    }

    public function test_rss_feed_excludes_draft_episode(): void
    {
        Episode::factory()->create([
            'title' => 'Unpublished Ep',
            'published_at' => null,
        ]);

        $this->get('/feed.rss')->assertDontSee('Unpublished Ep');
    }
}
