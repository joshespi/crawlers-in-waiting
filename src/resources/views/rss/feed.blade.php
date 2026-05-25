<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<rss version="2.0"
    xmlns:itunes="http://www.itunes.com/dtds/podcast-1.0.dtd"
    xmlns:content="http://purl.org/rss/1.0/modules/content/"
    xmlns:atom="http://www.w3.org/2005/Atom">
<channel>
    <title>{{ $podcast['title'] }}</title>
    <link>{{ $link }}</link>
    <description>{{ $podcast['description'] }}</description>
    <language>{{ $podcast['language'] }}</language>
    <atom:link href="{{ $feedUrl }}" rel="self" type="application/rss+xml"/>

    <image>
        <url>{{ asset('images/album.jpg') }}</url>
        <title>{{ $podcast['title'] }}</title>
        <link>{{ $link }}</link>
    </image>
    <itunes:image href="{{ asset('images/album.jpg') }}"/>
    <itunes:author>{{ $podcast['author'] }}</itunes:author>
    <itunes:owner>
        <itunes:name>{{ $podcast['author'] }}</itunes:name>
        <itunes:email>{{ $podcast['email'] }}</itunes:email>
    </itunes:owner>
    <itunes:category text="{{ $podcast['category'] }}"/>
    <itunes:explicit>{{ $podcast['explicit'] ? 'true' : 'false' }}</itunes:explicit>
    <itunes:type>episodic</itunes:type>

    @foreach($episodes as $episode)
    <item>
        <title>{{ $episode->episode_label }}: {{ $episode->title }}</title>
        <link>{{ route('episodes.show', $episode) }}</link>
        <guid isPermaLink="true">{{ route('episodes.show', $episode) }}</guid>
        <description><![CDATA[{{ $episode->description }}]]></description>
        <pubDate>{{ $episode->published_at->toRssString() }}</pubDate>
        <enclosure url="{{ $episode->audio_url }}" type="audio/mpeg" length="0"/>
        <itunes:duration>{{ $episode->duration_formatted }}</itunes:duration>
        <itunes:episode>{{ $episode->episode_number }}</itunes:episode>
        <itunes:season>{{ $episode->season_number }}</itunes:season>
        <itunes:image href="{{ $episode->cover_image_url ?? asset('images/album.jpg') }}"/>
        @if($episode->show_notes)
        <content:encoded><![CDATA[{!! nl2br(e($episode->show_notes)) !!}]]></content:encoded>
        @endif
    </item>
    @endforeach
</channel>
</rss>
