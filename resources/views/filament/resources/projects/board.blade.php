<x-filament::page>
    <div class="space-y-4">
        <div class="grid grid-cols-4 gap-4">
            @foreach ($record->boards as $board)
                <div class="bg-white shadow rounded p-4">
                    <h2 class="font-semibold">{{ $board }}</h2>
                </div>
            @endforeach
        </div>
    </div>
</x-filament::page>
