# Crawlers in Waiting

Podcast site for [crawlersinwaiting.com](https://crawlersinwaiting.com) — a Dungeon Crawler Carl fan podcast.


## RSS Feed

Submit `https://crawlersinwaiting.com/feed.rss` to podcast directories (Apple Podcasts, Spotify, etc.).

Podcast metadata is set via env vars — see `.env.example` for the full list.

## Episodes

Managed at `/admin/episodes`. Set `published_at` to schedule — leave blank for draft.

Audio files should be hosted externally (S3, Buzzsprout, etc.) and linked by URL.
`duration_seconds` is used in the RSS feed; convert `mm:ss` manually or use `ffprobe`.
