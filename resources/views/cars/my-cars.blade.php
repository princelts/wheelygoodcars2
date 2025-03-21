@extends('layouts.app')

@section('content')
<div class="mx-auto py-10 text-center">
    <h1 class="text-4xl font-bold">Mijn aanbod</h1>
    <h2 class="text-2xl">Bekijk en beheer je auto's</h2>
</div>

<div class="mx-auto max-w-7xl bg-white p-6 rounded-lg shadow-md">
    <h3 class="text-xl font-bold text-blue-600 mb-4">Mijn Autos</h3>
    
    <div class="table-responsive">
        <table class="table-auto w-full border-collapse">
            <thead class="bg-gray-50">
                <tr>
                    <th class="text-center px-6 py-4">Afbeelding</th>
                    <th class="px-6 py-4">Auto</th>
                    <th class="text-primary px-6 py-4">Prijs</th>
                    <th class="px-6 py-4">Merk & Model</th>
                    <th class="px-6 py-4">Tags</th>
                    <th class="px-6 py-4">Acties</th>
                </tr>
            </thead>
            <tbody>
                @foreach($myCars as $car)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="text-center py-4">
                            @if ($car->images)
                            <div class="flex space-x-2 mt-2">
                                @foreach (json_decode($car->images) as $image)
                                    <img src="{{ asset('storage/' . $image) }}" class="w-20 h-20 object-cover rounded">
                                @endforeach
                            </div>
                            @else
                                <img src="https://via.placeholder.com/150" class="w-20 h-20 object-cover rounded">
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            <h5 class="font-bold text-lg">{{ $car->license_plate }}</h5>
                            <span class="badge {{ $car->sold_at ? 'bg-red-600' : 'bg-green-600' }} text-white px-2 py-1 rounded-full text-xs">
                                {{ $car->sold_at ? 'Verkocht' : 'Te koop' }}
                            </span>
                        </td>
                        <td class="text-primary font-semibold py-4 px-6">€{{ number_format($car->price, 2, ',', '.') }}</td>
                        <td class="py-4 px-6">{{ $car->brand }} {{ $car->model }} ({{ $car->production_year }})</td>
                        <td class="py-4 px-6">
                            <div class="flex flex-wrap gap-2">
                                @foreach($car->tags as $tag)
                                    <span class="badge bg-gray-100 text-gray-700 border border-gray-300 px-2 py-1 rounded-full text-xs">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-2">
                                <form action="{{ route('cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze auto wilt verwijderen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">🗑 Verwijderen</button>
                                </form>
                                <a href="{{ route('generate-pdf', $car->id) }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm transition-colors">📥 Download PDF</a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection