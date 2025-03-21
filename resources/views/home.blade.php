@extends('layouts.app')

@section('content')

<div class="mx-auto py-10 text-center">
    <h1 class="text-4xl font-bold">Zoek en vergelijk</h1>
    <h2 class="text-2xl">op 40+ autosites tegelijk</h2>
</div>

<div class="mx-auto max-w-7xl bg-white text-black p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-bold text-blue-600 mb-4">NL aanbod</h3>
    
    <!-- Zoekformulier -->
<!-- resources/views/home.blade.php -->
<form action="{{ route('search.results') }}" method="GET" class="mb-6">
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
        <!-- Merk -->
        <select name="brand" class="border p-2 rounded">
            <option value="">Merk...</option>
            @foreach($brands as $brand)
                <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
            @endforeach
        </select>

        <!-- Model -->
        <select name="model" class="border p-2 rounded">
            <option value="">Model...</option>
            @foreach($models as $model)
                <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>{{ $model }}</option>
            @endforeach
        </select>

        <!-- Kilometerstand -->
        <div class="flex gap-2">
            <span class="font-bold">Km.stand</span>
            <input type="number" name="min_mileage" placeholder="Min" class="border p-2 rounded w-24" value="{{ request('min_mileage') }}">
            <input type="number" name="max_mileage" placeholder="Max" class="border p-2 rounded w-24" value="{{ request('max_mileage') }}">
        </div>

        <!-- Bouwjaar -->
        <div class="flex gap-2">
            <span class="font-bold">Bouwjaar</span>
            <input type="number" name="min_year" placeholder="Min" class="border p-2 rounded w-24" value="{{ request('min_year') }}">
            <input type="number" name="max_year" placeholder="Max" class="border p-2 rounded w-24" value="{{ request('max_year') }}">
        </div>

        <!-- Prijs -->
        <div class="flex gap-2">
            <span class="font-bold">Prijs</span>
            <input type="number" name="min_price" placeholder="Min" class="border p-2 rounded w-24" value="{{ request('min_price') }}">
            <input type="number" name="max_price" placeholder="Max" class="border p-2 rounded w-24" value="{{ request('max_price') }}">
        </div>

    </div>

    <div class="mt-4 flex justify-between items-center">
        <!-- Wis knop -->
        <a href="{{ route('home') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Wis</a>
        <!-- Zoek knop -->
        <button type="submit" class="bg-orange-500 text-white px-6 py-3 rounded font-bold">Vinden</button>
    </div>
</form>

    <!-- Resultaten -->
    {{-- <div class="mt-6">
        @if($cars->isEmpty())
            <p class="text-center text-gray-500">Geen auto's gevonden.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($cars as $car)
                    <div class="bg-white p-4 rounded-lg shadow-md">
                        <div class="text-center">
                            @if($car->image)
                                <img src="{{ asset('storage/' . $car->image) }}" alt="{{ $car->brand }} {{ $car->model }}" class="w-full h-48 object-cover rounded-lg">
                            @else
                                <div class="w-full h-48 bg-gray-200 flex items-center justify-center rounded-lg">
                                    <span class="text-gray-500">Geen afbeelding</span>
                                </div>
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
        @endif
    </div>
</div> --}}
@endsection