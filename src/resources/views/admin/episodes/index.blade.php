@extends('layouts.admin')

@section('content')
<div class="flex items-center justify-between mb-6">
    <h1 class="text-lg font-bold text-stone-200 tracking-wide">Episodes</h1>
    <a href="{{ route('admin.episodes.create') }}"
       class="bg-amber-800 hover:bg-amber-700 text-amber-100 text-sm font-bold px-4 py-2 rounded transition-colors">
        + New Episode
    </a>
</div>

@if($episodes->isEmpty())
    <p class="text-stone-600">No episodes yet.</p>
@else
    <div class="border border-stone-800 rounded overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-stone-900 text-stone-500 text-xs tracking-widest">
                <tr>
                    <th class="text-left px-4 py-3">EP</th>
                    <th class="text-left px-4 py-3">TITLE</th>
                    <th class="text-left px-4 py-3">PUBLISHED</th>
                    <th class="text-left px-4 py-3">DURATION</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-stone-800">
                @foreach($episodes as $episode)
                <tr class="hover:bg-stone-900/50 transition-colors">
                    <td class="px-4 py-3 text-amber-700 font-bold text-xs">{{ $episode->episode_label }}</td>
                    <td class="px-4 py-3 text-stone-200">
                        <a href="{{ route('episodes.show', $episode) }}" target="_blank"
                           class="hover:text-amber-400 transition-colors">
                            {{ $episode->title }}
                        </a>
                    </td>
                    <td class="px-4 py-3 text-stone-500">
                        {{ $episode->published_at ? $episode->published_at->format('M j, Y') : '— draft —' }}
                    </td>
                    <td class="px-4 py-3 text-stone-500">{{ $episode->duration_formatted }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center gap-4 justify-end">
                            <a href="{{ route('admin.episodes.edit', $episode) }}"
                               class="text-stone-500 hover:text-amber-400 transition-colors text-xs">Edit</a>
                            <form method="POST" action="{{ route('admin.episodes.destroy', $episode) }}"
                                  onsubmit="return confirm('Delete {{ addslashes($episode->title) }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-stone-600 hover:text-red-400 transition-colors text-xs">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $episodes->links() }}</div>
@endif
@endsection
