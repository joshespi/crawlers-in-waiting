@php
    $socials = array_filter([
        'Facebook'  => config('social.facebook'),
        'Twitter'   => config('social.twitter'),
        'Instagram' => config('social.instagram'),
    ]);
@endphp
@if($socials)
<div class="flex justify-center gap-4 text-stone-500">
    @foreach($socials as $label => $url)
        <a href="{{ $url }}" target="_blank" rel="noopener" class="hover:text-amber-500 transition-colors">{{ $label }}</a>
    @endforeach
</div>
@endif
