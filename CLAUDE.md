# CLAUDE.md

Podcast site for crawlersinwaiting.com — a Dungeon Crawler Carl fan podcast.

## Commands

All PHP/Node work runs inside Docker. App container is `ciw-app`.

```bash
# Start the stack
docker compose up -d --build

# Run tests
docker compose exec app php artisan test

# Artisan
docker compose exec app php artisan <command>

# Frontend build (dev watch)
docker compose exec app npm run dev

# Logs
docker compose logs -f app
```

Migrations run automatically on container start via `docker/php/entrypoint.sh`.

## First run

```bash
bash scripts/setup.sh --seed
```

This generates `APP_KEY`, runs migrations, and seeds the admin user + sample episodes.
Admin credentials come from `ADMIN_EMAIL` / `ADMIN_PASSWORD` in `.env`.

## Architecture

Laravel app lives in `src/`. Root contains only Docker config and scripts.

### Domain

Single domain: **Episodes**. An episode has a season/number, title, slug, description,
show notes, audio URL, duration, optional cover image, and a `published_at` timestamp.
`published_at = null` means draft — hidden from public, visible in admin.

### Routes

| Path | Purpose |
|---|---|
| `/` | Public episode list (paginated) |
| `/episodes/{slug}` | Single episode + audio player |
| `/about` | About the show |
| `/feed.rss` | RSS feed for podcast directories |
| `/login` | Admin login |
| `/admin/episodes` | Episode CRUD |

### Podcast config

Podcast metadata (title, description, author, category, etc.) lives in `config/podcast.php`,
populated from env vars. The RSS feed at `/feed.rss` is what you submit to Apple Podcasts,
Spotify, etc.

### Testing

Tests use SQLite in-memory. The same pattern as finance-laravel — no `DATE_FORMAT` raw SQL,
group-by-month in PHP.

### Frontend

Blade + Tailwind v4. Dark stone/amber theme. No Alpine or JS framework — audio player is
native HTML5 `<audio>`. Pagination uses Laravel's default views.
