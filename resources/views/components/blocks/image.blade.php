@props(['data'])

<div class="my-6">
    <img 
        src="{{ asset('storage/' . $data['url']) }}" 
        alt="{{ $data['alt'] ?? '' }}"
        class="{{ $data['width'] === 'half' ? 'w-1/2 mx-auto' : 'w-full' }} rounded-lg shadow-lg"
    >
    @if(!empty($data['alt']))
        <p class="text-sm text-gray-600 text-center mt-2">{{ $data['alt'] }}</p>
    @endif
</div>
