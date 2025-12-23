<x-landing-layout>
    <x-landing.header />
    
    <main class="flex-grow">
        <article class="max-w-4xl mx-auto px-4 py-16">
            {{-- Cover Image --}}
            @if($content->cover_image)
                <img src="{{ asset('storage/' . $content->cover_image) }}" alt="{{ $content->title }}" class="w-full rounded-lg mb-8 shadow-lg">
            @endif

            {{-- Title --}}
            <h1 class="text-4xl md:text-5xl font-bold mb-4 text-gray-900">{{ $content->title }}</h1>

            {{-- Published Date --}}
            @if($content->published_at)
                <p class="text-gray-600 mb-8 text-sm">{{ $content->published_at->format('d F Y') }}</p>
            @endif

            {{-- Content (RichEditor output) --}}
            <div class="prose prose-lg max-w-none">
                {!! $content->content ?? '' !!}
            </div>
        </article>
    </main>

    <x-landing.footer />
</x-landing-layout>
