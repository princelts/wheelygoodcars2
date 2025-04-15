@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
            <!-- Car Images -->
            <div class="space-y-4">
                @if ($car->images)
                    <div class="grid grid-cols-1 gap-4">
                        @foreach (json_decode($car->images) as $image)
                            <div class="relative group overflow-hidden rounded-lg shadow-md">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-105 transition duration-300">
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="relative group overflow-hidden rounded-lg shadow-md">
                        <img src="https://placehold.co/600x400/EEE/31343C" 
                             class="w-full h-full object-cover transform group-hover:scale-105 transition duration-300">
                    </div>
                @endif
            </div>

            <!-- Car Details -->
            <div class="space-y-6">
                <!-- Title and Price -->
                <div class="border-b border-gray-100 pb-4">
                    <h1 class="text-3xl font-bold text-gray-900">{{ $car->brand }} {{ $car->model }}</h1>
                    <div class="flex items-center justify-between mt-2">
                        <p class="text-gray-600">{{ $car->production_year }} • {{ number_format($car->mileage, 0, ',', '.') }} km</p>
                        <p class="text-blue-600 font-bold text-2xl">€{{ number_format($car->price, 2, ',', '.') }}</p>
                    </div>
                </div>

                <!-- Quick Stats -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Aantal keer bekeken</p>
                        <p class="font-semibold">{{ $car->views }} keer</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Kenteken</p>
                        <p class="font-semibold">{{ $car->license_plate }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Kleur</p>
                        <p class="font-semibold">{{ $car->color }}</p>
                    </div>
                    <div class="bg-gray-50 p-3 rounded-lg">
                        <p class="text-sm text-gray-500">Gewicht</p>
                        <p class="font-semibold">{{ $car->weight }} kg</p>
                    </div>
                </div>

                <!-- Specifications -->
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-gray-900">Specificaties</h2>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600">Aantal deuren</p>
                            <p class="font-semibold">{{ $car->doors }}</p>
                        </div>
                        <div>
                            <p class="text-gray-600">Zitplaatsen</p>
                            <p class="font-semibold">{{ $car->seats }}</p>
                        </div>
                    </div>
                </div>

                <!-- Tags -->
                @if($car->tags->count() > 0)
                    <div class="space-y-2">
                        <h2 class="text-xl font-bold text-gray-900">Kenmerken</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($car->tags as $tag)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                    {{ $tag->name }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Contact/Call to Action Section -->
        <div class="bg-gray-50 px-6 py-4 border-t border-gray-200">
            <div class="flex flex-col sm:flex-row justify-between items-center">
                <p class="text-gray-600 mb-2 sm:mb-0">Geïnteresseerd in deze auto?</p>
                <button class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg transition duration-200">
                    Contact opnemen
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Popup Notification -->
<div id="viewsPopup" class="fixed bottom-6 right-6 bg-white p-4 rounded-xl shadow-xl border border-blue-200 hidden z-50 max-w-xs">
    <div class="flex items-start">
        <div class="bg-blue-100 p-2 rounded-full mr-3 flex-shrink-0">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </div>
        <div class="flex-1">
            <div class="flex justify-between items-start">
                <p class="font-semibold">{{ rand(5, 20) }} klanten bekeken deze auto vandaag</p>
                <button onclick="document.getElementById('viewsPopup').classList.add('hidden')" 
                        class="text-gray-400 hover:text-gray-600 ml-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                    </svg>
                </button>
            </div>
            <p class="text-sm text-gray-600 mt-1">Wees er snel bij!</p>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        setTimeout(function() {
            const popup = document.getElementById('viewsPopup');
            popup.classList.remove('hidden');
            
            // Hide popup after 10 seconds
            setTimeout(function() {
                popup.classList.add('hidden');
            }, 10000);
        }, 10000);
    });
</script>
@endsection