@props(['data'])

<div class="my-8 text-center">
    <a 
        href="{{ $data['link'] }}" 
        class="inline-block px-8 py-3 rounded-lg text-white font-semibold text-lg hover:opacity-90 transition"
        style="background-color: {{ $data['color'] }}"
    >
        {{ $data['text'] }}
    </a>
</div>
