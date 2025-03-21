@extends('layouts.app')

@section('content')
<div class="mx-auto py-10 text-center">
    <h1 class="text-4xl font-bold">Zoekresultaten</h1>
    <h2 class="text-2xl">Gevonden auto's: {{ $totalCars }}</h2>
</div>

<div class="mx-auto max-w-7xl bg-white text-black p-6 rounded-lg shadow-md">
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($cars as $car)
            <div class="bg-white p-4 rounded-lg shadow-md">
                <div class="text-center">
                    @if ($car->images)
                    <div class="flex space-x-2 mt-2">
                        @foreach (json_decode($car->images) as $image)
                            <img src="{{ asset('storage/' . $image) }}" class="w-20 h-20 object-cover rounded">
                        @endforeach
                    </div>
                    @else
                        <img src="https://placehold.co/600x400/EEE/31343C" class="w-20 h-20 object-cover rounded">
                    @endif
                </div>
                <h4 class="text-xl font-bold mt-4">{{ $car->brand }} {{ $car->model }}</h4>
                <p class="text-gray-600">{{ $car->production_year }} | {{ $car->mileage }} km</p>
                <p class="text-blue-600 font-bold">€{{ number_format($car->price, 2, ',', '.') }}</p>
                <div class="mt-2">
                    @foreach($car->tags as $tag)
                        <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-xs mr-2">{{ $tag->name }}</span>
                    @endforeach
                </div>
            </div>
        @endforeach
    </div>

    <!-- Paginatie -->
    <div class="mt-6">
        {{ $cars->links() }}
    </div>
</div>
@endsection