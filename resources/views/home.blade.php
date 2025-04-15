@extends('layouts.app')

@section('content')

<div class="mx-auto py-10 text-center">
    <h1 class="text-4xl font-bold">Zoek en vergelijk</h1>
    <h2 class="text-2xl">op 40+ autosites tegelijk</h2>
</div>

<div class="mx-auto max-w-7xl  text-black p-6">
    
    <!-- Zoekformulier -->
<!-- Zoekformulier -->
<div class="bg-white rounded-xl shadow-md border border-gray-100 hover:border-blue-200 transition-all duration-300 p-6 mt-6">
    <form action="{{ route('search.results') }}" method="GET">
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            <!-- Merk -->
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-gray-600 mb-1">Merk</label>
                <select name="brand" class="border border-gray-300 p-3 rounded-lg w-full focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Merk...</option>
                    @foreach($brands as $brand)
                        <option value="{{ $brand }}" {{ request('brand') == $brand ? 'selected' : '' }}>{{ $brand }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Model -->
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-gray-600 mb-1">Model</label>
                <select name="model" class="border border-gray-300 p-3 rounded-lg w-full focus:ring-blue-500 focus:border-blue-500">
                    <option value="">Model...</option>
                    @foreach($models as $model)
                        <option value="{{ $model }}" {{ request('model') == $model ? 'selected' : '' }}>{{ $model }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Kilometerstand -->
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-gray-600 mb-1">Km.stand</label>
                <div class="flex gap-2">
                    <input type="number" name="min_mileage" placeholder="Min" class="border border-gray-300 p-2 rounded-lg w-full" value="{{ request('min_mileage') }}">
                    <input type="number" name="max_mileage" placeholder="Max" class="border border-gray-300 p-2 rounded-lg w-full" value="{{ request('max_mileage') }}">
                </div>
            </div>

            <!-- Bouwjaar -->
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-gray-600 mb-1">Bouwjaar</label>
                <div class="flex gap-2">
                    <input type="number" name="min_year" placeholder="Min" class="border border-gray-300 p-2 rounded-lg w-full" value="{{ request('min_year') }}">
                    <input type="number" name="max_year" placeholder="Max" class="border border-gray-300 p-2 rounded-lg w-full" value="{{ request('max_year') }}">
                </div>
            </div>

            <!-- Prijs -->
            <div class="flex flex-col">
                <label class="text-sm font-semibold text-gray-600 mb-1">Prijs</label>
                <div class="flex gap-2">
                    <input type="number" name="min_price" placeholder="Min" class="border border-gray-300 p-2 rounded-lg w-full" value="{{ request('min_price') }}">
                    <input type="number" name="max_price" placeholder="Max" class="border border-gray-300 p-2 rounded-lg w-full" value="{{ request('max_price') }}">
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-between">
            <a href="{{ route('home') }}" class="bg-white text-blue-600 border border-blue-600 px-6 py-3 rounded font-bold hover:bg-blue-600 hover:text-white transition">Wis</a>
    <button type="submit"
            class="            bg-blue-600 text-white px-5 py-3 rounded-lg font-semibold hover:bg-blue-700 transition">
        Vinden
    </button>
        </div>
    </form>
</div>

@endsection