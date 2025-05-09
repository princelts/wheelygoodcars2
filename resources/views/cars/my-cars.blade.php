@extends('layouts.app')

@section('content')
<div class="w-full lg:w-3/4 mx-auto">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold">Mijn aanbod</h1>
        <p class="text-gray-600">Bekijk en beheer je auto's</p>
    </div>

    <!-- Table Container -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden border border-gray-100">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Afbeelding</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Auto</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prijs</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Details</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tags</th>
                        <th class="px-6 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Acties</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @foreach($myCars as $car)
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        <!-- Image Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex-shrink-0 h-16 w-16">
                                @if ($car->images)
                                    <img class="h-16 w-16 rounded-md object-cover" src="{{ asset('storage/' . json_decode($car->images)[0]) }}" alt="">
                                @else
                                    <img class="h-16 w-16 rounded-md object-cover" src="https://placehold.co/150?text=Geen+afbeelding" alt="">
                                @endif
                            </div>
                        </td>
                        
                        <!-- Car Info Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $car->license_plate }}</div>
                                    <div class="mt-1">
                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $car->sold_at ? 'bg-red-100 text-red-800' : 'bg-green-100 text-green-800' }}">
                                            {{ $car->sold_at ? 'Verkocht' : 'Te koop' }}
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <!-- Price Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-bold text-blue-600">€{{ number_format($car->price, 2, ',', '.') }}</div>
                        </td>
                        
                        <!-- Details Column -->
                        <td class="px-6 py-4">
                            <div class="text-sm text-gray-900">{{ $car->brand }} {{ $car->model }}</div>
                            <div class="text-sm text-gray-500">{{ $car->production_year }}</div>
                        </td>
                        
                        <!-- Tags Column -->
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @foreach($car->tags as $tag)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $tag->name }}
                                    </span>
                                @endforeach
                            </div>
                        </td>
                        
                        <!-- Actions Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex space-x-2">
                                <form action="{{ route('cars.destroy', $car->id) }}" method="POST" onsubmit="return confirm('Weet je zeker dat je deze auto wilt verwijderen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-red-600 hover:bg-red-700 focus:outline-none transition-colors">
                                        Verwijderen
                                    </button>
                                </form>
                                <a href="{{ route('generate-pdf', $car->id) }}" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none transition-colors">
                                    PDF
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection