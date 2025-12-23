@props(['data'])

<div class="my-8 space-y-4">
    @foreach($data['items'] as $item)
        <details class="bg-gray-50 rounded-lg p-4">
            <summary class="font-semibold cursor-pointer">{{ $item['question'] }}</summary>
            <p class="mt-2 text-gray-700">{{ $item['answer'] }}</p>
        </details>
    @endforeach
</div>
