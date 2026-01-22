@extends('layouts.app')

@section('title', $category->name . ' - Toolbox')

@section('content')
<div class="mb-8">
    <div class="flex items-center mb-4">
        <span class="text-4xl mr-4">{{ $category->icon }}</span>
        <div>
            <h1 class="text-4xl font-bold text-gray-900 dark:text-white">{{ $category->name }}</h1>
            @if($category->description)
            <p class="text-gray-600 dark:text-gray-400 mt-2">{{ $category->description }}</p>
            @endif
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    @foreach($tools as $tool)
    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md hover:shadow-xl transition p-6 group relative">
        <!-- Favorite Button -->
        @auth
        <button
            onclick="toggleFavorite({{ $tool->id }}, this)"
            class="absolute top-4 right-4 text-xl hover:scale-125 transition-transform favorite-btn"
            data-tool-id="{{ $tool->id }}"
            title="Add to favorites"
        >
            @if(auth()->user()->favorites->contains('tool_id', $tool->id))
                ⭐
            @else
                ☆
            @endif
        </button>
        @endauth

        <a href="{{ route('tools.show', $tool->slug) }}" class="block">
            <div class="flex items-start justify-between mb-3 pr-8">
                <h3 class="font-semibold text-lg text-gray-900 dark:text-white group-hover:text-primary-600 dark:group-hover:text-primary-400 transition">
                    {{ $tool->name }}
                </h3>
                @if($tool->is_new)
                <span class="bg-green-500 text-white text-xs px-2 py-1 rounded-full">NEW</span>
                @endif
            </div>
            <p class="text-gray-600 dark:text-gray-400">{{ $tool->description }}</p>
            <div class="mt-4 text-sm text-gray-500 dark:text-gray-400">
                Used {{ number_format($tool->usage_count) }} times
            </div>
        </a>
    </div>
    @endforeach
</div>

<div class="mt-8">
    {{ $tools->links() }}
</div>

@auth
@push('scripts')
<script>
function toggleFavorite(toolId, btn) {
    fetch('{{ route("favorites.toggle") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ tool_id: toolId })
    })
    .then(response => response.json())
    .then(data => {
        btn.textContent = data.favorited ? '⭐' : '☆';
    });
}
</script>
@endpush
@endauth
@endsection
