@extends('layouts.app')

@section('content')

<div class="-my-4 h-screen bg-no-repeat bg-center bg-cover bg-[url(/storage/background/BMW-background.jpg)]">

    <div class="mx-auto py-8 md:py-10 text-white text-center px-4 ">
        <div class="max-w-4xl mx-auto">
            <h1 class="text-4xl md:text-5xl font-bold mb-3 [text-shadow:_0_2px_4px_rgba(0,0,0,0.5)]">
                Zoek en vergelijk uw perfecte auto
            </h1>
            <h2 class="text-xl md:text-2xl font-medium mb-4 opacity-90 [text-shadow:_0_1px_3px_rgba(0,0,0,0.4)]">
                Vind de beste deals uit ons uitgebreide aanbod
            </h2>
        </div>
    </div>

    <div class="mx-auto max-w-7xl text-black p-6">
        
    <!-- Zoekformulier -->
        <div class="bg-white rounded-xl shadow-md border border-gray-100 hover:border-blue-200 transition-all duration-300 p-6">
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
    </div>
</div>

@endsection