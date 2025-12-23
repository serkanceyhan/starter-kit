@props(['data'])

<div class="my-8 grid grid-cols-{{ $data['count'] }} gap-6">
    @foreach($data['items'] as $item)
        <div class="bg-white rounded-lg shadow p-6">
            @if(!empty($item['icon']))
                <img src="{{ asset('storage/' . $item['icon']) }}" alt="" class="w-16 h-16 mb-4">
            @endif
            @if(!empty($item['title']))
                <h3 class="text-xl font-semibold mb-2">{{ $item['title'] }}</h3>
            @endif
            <div class="prose">{!! $item['content'] !!}</div>
        </div>
    @endforeach
</div>
