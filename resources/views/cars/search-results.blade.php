@extends('layouts.app')

@section('content')
<div class="mx-auto py-10 text-center">
    <h1 class="text-4xl font-bold">Zoekresultaten</h1>
    <h2 class="text-2xl">Gevonden auto's: {{ $totalCars }}</h2>
</div>

<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
    <!-- Enhanced grid with 4 columns -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        @foreach($cars as $car)
            @php
                // 15% chance to highlight a car (span 2 columns)
                $isFeatured = rand(1, 100) <= 10;
                $colSpan = $isFeatured ? 'lg:col-span-2' : '';
                $bgGradient = $isFeatured ? 'bg-gradient-to-br from-blue-50 to-white' : 'bg-white';
            @endphp

            <a href="{{ route('cars.show', $car->id) }}" 
               class="group relative {{ $colSpan }} {{ $bgGradient }} rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-200">
                <!-- Featured badge -->
                @if($isFeatured)
                    <div class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full z-10">
                        POPULAIR
                    </div>
                @endif

                <!-- Image container -->
                <div class="h-48 w-full overflow-hidden">
                    @if ($car->images)
                        <img src="{{ asset('storage/' . json_decode($car->images)[0]) }}" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @else
                        <img src="https://placehold.co/600x400/EEE/31343C" 
                             class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    @endif
                </div>

                <!-- Card content -->
                <div class="p-4">
                    <div class="flex justify-between items-start">
                        <div class="w-full">
                            <h3 class="text-lg font-bold text-gray-900 group-hover:text-blue-600 transition-colors truncate block max-w-full">
                                {{ $car->brand }} {{ $car->model }}
                            </h3>
                        </div>

                    </div>

                    <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                        <span>{{ $car->production_year }}</span>
                        <span>•</span>
                        <span>{{ number_format($car->mileage, 0, ',', '.') }} km</span>
                        <span>•</span>
                        <span>{{ $car->doors }} deur{{ $car->doors > 1 ? 'en' : '' }}</span>
                    </div>


                    <div class="mt-3 flex items-center justify-between">
                        <p class="text-lg font-bold text-blue-600">
                            €{{ number_format($car->price, 2, ',', '.') }}
                        </p>
                        @if($car->views > 50)
                            <span class="flex items-center text-sm text-gray-500">
                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                                {{ $car->views }}
                            </span>
                        @endif
                    </div>

                    <!-- Tags -->
                    @if($car->tags->count() > 0)
                        <div class="mt-3 flex flex-wrap gap-1">
                            @foreach($car->tags as $tag)
                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
            </a>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="mt-8">
        {{ $cars->links() }}
    </div>
</div>
@endsection