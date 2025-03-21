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
                {{-- <div class="text-center">
                    @if($car->image)
                        <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-48 object-cover rounded-lg">
                    @else
                        <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-lg">
                            <span class="text-gray-500">Geen afbeelding</span>
                        </div>
                    @endif
                </div> --}}
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