@extends('layouts.app')

@section('content')

<div class="flex flex-col lg:flex-row gap-6 mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">

    <div class="w-full lg:w-1/4">
        <form action="{{ route('search.results') }}" method="GET">
            <!-- Preserve search query if it exists -->
            @if(request()->query('query'))
                <input type="hidden" name="query" value="{{ request()->query('query') }}">
            @endif
            
            <div class="bg-white p-6 rounded-xl shadow-md sticky top-6">
                <h2 class="text-xl font-bold mb-4">Filters</h2>
                
                <!-- Price Filter -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-900 mb-2">Prijsbereik (€)</h3>
                    <div class="flex gap-2">
                        <input type="number" name="min_price" id="min_price" 
                               value="{{ request()->input('min_price') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm"
                               placeholder="Min" min="0">
                        <input type="number" name="max_price" id="max_price" 
                               value="{{ request()->input('max_price') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm"
                               placeholder="Max" min="0">
                    </div>
                </div>
                
                <!-- Brand Filter -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-900 mb-2">Merk</h3>
                    <select name="brand" id="brand" class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm">
                        <option value="">Alle merken</option>
                        @foreach($brands as $brandOption)
                            <option value="{{ $brandOption }}" 
                                {{ request()->input('brand') == $brandOption ? 'selected' : '' }}>
                                {{ $brandOption }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <!-- Year Filter -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-900 mb-2">Bouwjaar</h3>
                    <div class="flex gap-2">
                        <input type="number" name="min_year" id="min_year" 
                               value="{{ request()->input('min_year') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm"
                               placeholder="Van" min="1900" max="{{ date('Y') }}">
                        <input type="number" name="max_year" id="max_year" 
                               value="{{ request()->input('max_year') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm"
                               placeholder="Tot" min="1900" max="{{ date('Y') }}">
                    </div>
                </div>
                
                <!-- Mileage Filter -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-900 mb-2">Kilometerstand</h3>
                    <div class="flex gap-2">
                        <input type="number" name="min_mileage" id="min_mileage" 
                               value="{{ request()->input('min_mileage') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm"
                               placeholder="Min" min="0">
                        <input type="number" name="max_mileage" id="max_mileage" 
                               value="{{ request()->input('max_mileage') }}"
                               class="w-full px-3 py-2 border border-gray-300 rounded-md text-sm"
                               placeholder="Max" min="0">
                    </div>
                </div>

                <!-- Tags Filter -->
                <div class="mb-6">
                    <h3 class="font-medium text-gray-900 mb-2">Tags</h3>
                    <div class="space-y-2 max-h-[500px] overflow-y-auto p-1" x-data="{
                        openGroups: JSON.parse(localStorage.getItem('openTagGroups')) || [],
                        toggleGroup(group) {
                            if (this.openGroups.includes(group)) {
                                this.openGroups = this.openGroups.filter(g => g !== group);
                            } else {
                                this.openGroups.push(group);
                            }
                            localStorage.setItem('openTagGroups', JSON.stringify(this.openGroups));
                        },
                        isGroupOpen(group) {
                            return this.openGroups.includes(group);
                        }
                    }">
                        @foreach($tagGroups as $group => $tags)
                            <div class="border border-gray-200 rounded-lg overflow-hidden">
                                <button type="button"
                                        @click="toggleGroup('{{ $group }}')"
                                        class="w-full flex justify-between items-center p-3 bg-gray-50 hover:bg-gray-100 transition-colors">
                                    <span class="font-medium text-gray-700">{{ $group }}</span>
                                    <svg x-show="!isGroupOpen('{{ $group }}')" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                    <svg x-show="isGroupOpen('{{ $group }}')" class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path>
                                    </svg>
                                </button>
                                <div x-show="isGroupOpen('{{ $group }}')" x-collapse class="p-3 space-y-2">
                                    @foreach($tags as $tag)
                                        <div class="flex items-center">
                                            <input type="checkbox" name="tags[]" id="tag-{{ $tag->id }}" 
                                                   value="{{ $tag->id }}"
                                                   class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500"
                                                   {{ in_array($tag->id, (array)request()->input('tags', [])) ? 'checked' : '' }}>
                                            <label for="tag-{{ $tag->id }}" class="ml-2 text-sm text-gray-700 flex items-center">
                                                <span class="inline-block w-3 h-3 rounded-full mr-2" style="background-color: {{ $tag->color }}"></span>
                                                {{ $tag->name }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                
                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-md text-sm">
                        Filters toepassen
                    </button>
                    @if(request()->except('query'))
                        <a href="{{ route('search.results', ['query' => request()->query('query')]) }}" 
                           class="flex-1 bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium py-2 px-4 rounded-md text-sm text-center">
                            Reset
                        </a>
                    @endif
                </div>
            </div>
        </form>
    </div>
    <!-- Main Content -->
    <div class="w-full lg:w-3/4">
                
        <!-- Results Count -->
        <div class="mb-6">
            <h1 class="text-2xl font-bold">Zoekresultaten</h1>
            <p class="text-gray-600">{{ $totalCars }} auto's gevonden</p>
        </div>
        <!-- Search Bar -->
        <div class="bg-white p-6 rounded-xl shadow-md mb-6">
            <form action="{{ route('search.results') }}" method="GET">
                <div class="flex">
                    <input type="text" name="query" value="{{ request('query') }}"
                           class="flex-grow px-4 py-3 border border-gray-300 rounded-l-md focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Zoek op merk, model, of andere kenmerken...">
                    <button type="submit" 
                            class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-3 rounded-r-md">
                        Zoeken
                    </button>
                </div>
            </form>
        </div>
        
        <!-- Cars Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($cars as $car)
                @php
                    $isFeatured = rand(1, 100) <= 10;
                    $colSpan = $isFeatured ? 'lg:col-span-2' : '';
                    $bgGradient = $isFeatured ? 'bg-gradient-to-br from-blue-50 to-white' : 'bg-white';
                @endphp

                <a href="{{ route('cars.show', $car->id) }}" 
                   class="group relative {{ $colSpan }} {{ $bgGradient }} rounded-xl shadow-md hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 hover:border-blue-200">
                    @if($isFeatured)
                        <div class="absolute top-3 left-3 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded-full z-10">
                            POPULAIR
                        </div>
                    @endif

                    <div class="h-48 w-full overflow-hidden">
                        @if ($car->images)
                            <img src="{{ asset('storage/' . json_decode($car->images)[0]) }}" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @else
                            <img src="https://placehold.co/600x400/EEE/31343C" 
                                 class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        @endif
                    </div>

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
</div>
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>

@endsection