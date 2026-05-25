<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EpisodeFactory extends Factory
{
    public function definition(): array
    {
        $titles = [
            'Carl Hits the Dungeon Running',
            'Donut Discovers Her Power',
            'The Princess Bitch Problem',
            'Floor Two: Things Get Worse',
            'Mordecai Explains Everything (Sort Of)',
            'When the Loot Box Betrays You',
            'Borant Corp\'s Most Wanted',
            'The Crawlers We Left Behind',
            'Safe Room Confessions',
            'What Even Is a Naiad',
        ];

        $title = fake()->unique()->randomElement($titles);

        return [
            'episode_number' => fake()->unique()->numberBetween(1, 100),
            'season_number' => 1,
            'title' => $title,
            'slug' => Str::slug($title),
            'description' => fake()->paragraph(3),
            'show_notes' => fake()->paragraphs(5, true),
            'audio_url' => 'https://cdn.crawlersinwaiting.com/episodes/' . Str::slug($title) . '.mp3',
            'duration_seconds' => fake()->numberBetween(1800, 5400),
            'cover_image_url' => null,
            'published_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }

    public function draft(): static
    {
        return $this->state(['published_at' => null]);
    }
}
