@props(['data'])

<div class="grid grid-cols-2 gap-8 my-8 items-center">
    @if($data['layout'] === 'image-left')
        <img src="{{ asset('storage/' . $data['image']) }}" alt="" class="rounded-lg shadow-lg">
        <div class="prose">{!! $data['text'] !!}</div>
    @else
        <div class="prose">{!! $data['text'] !!}</div>
        <img src="{{ asset('storage/' . $data['image']) }}" alt="" class="rounded-lg shadow-lg">
    @endif
</div>
