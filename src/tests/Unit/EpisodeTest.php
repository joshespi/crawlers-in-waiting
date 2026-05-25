<?php

namespace Tests\Unit;

use App\Models\Episode;
use PHPUnit\Framework\TestCase;

class EpisodeTest extends TestCase
{
    public function test_duration_formatted_under_one_hour(): void
    {
        $episode = new Episode(['duration_seconds' => 2754]); // 45:54
        $this->assertSame('45:54', $episode->duration_formatted);
    }

    public function test_duration_formatted_over_one_hour(): void
    {
        $episode = new Episode(['duration_seconds' => 3723]); // 1:02:03
        $this->assertSame('1:02:03', $episode->duration_formatted);
    }

    public function test_duration_formatted_exact_hour(): void
    {
        $episode = new Episode(['duration_seconds' => 3600]); // 1:00:00
        $this->assertSame('1:00:00', $episode->duration_formatted);
    }

    public function test_episode_label_format(): void
    {
        $episode = new Episode(['season_number' => 2, 'episode_number' => 7]);
        $this->assertSame('S2E7', $episode->episode_label);
    }
}
