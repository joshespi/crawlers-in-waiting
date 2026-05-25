<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Episode extends Model
{
    use HasFactory;

    protected $fillable = [
        'episode_number',
        'season_number',
        'title',
        'slug',
        'description',
        'show_notes',
        'audio_url',
        'duration_seconds',
        'cover_image_url',
        'published_at',
    ];

    protected $casts = [
        'published_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeNewest(Builder $query): Builder
    {
        return $query->orderBy('published_at', 'desc');
    }

    public function getDurationFormattedAttribute(): string
    {
        $h = intdiv($this->duration_seconds, 3600);
        $m = intdiv($this->duration_seconds % 3600, 60);
        $s = $this->duration_seconds % 60;

        return $h > 0
            ? sprintf('%d:%02d:%02d', $h, $m, $s)
            : sprintf('%d:%02d', $m, $s);
    }

    public function getEpisodeLabelAttribute(): string
    {
        return "S{$this->season_number}E{$this->episode_number}";
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
