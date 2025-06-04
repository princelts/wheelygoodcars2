@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
    <!-- Main Card -->
    <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
        <form action="{{ route('cars.update', $car->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 p-6">
                <!-- Car Images -->
                <div class="space-y-4">
                    <h2 class="text-xl font-bold text-gray-900">Afbeeldingen</h2>
                    
                    <!-- Current Images -->
                    @if ($car->images)
                        <div class="grid grid-cols-3 gap-2 mb-4">
                            @foreach (json_decode($car->images) as $index => $image)
                                <div class="relative group">
                                    <img src="{{ asset('storage/' . $image) }}" class="w-full h-24 object-cover rounded-lg">
                                    <button type="button" onclick="removeImage(this, {{ $index }})" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    @endif
                    
                    <!-- Image Upload -->
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center">
                        <input type="file" name="images[]" id="images" multiple accept="image/*" class="hidden">
                        <label for="images" class="cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <p class="mt-1 text-sm text-gray-600">Klik om afbeeldingen toe te voegen</p>
                            <p class="text-xs text-gray-500">Sleep afbeeldingen hierheen of klik om te selecteren</p>
                        </label>
                    </div>
                    
                    <!-- Hidden field for removed images -->
                    <input type="hidden" name="removed_images" id="removed_images" value="">
                </div>

                <!-- Car Details -->
                <div class="space-y-6">
                    <!-- Title and Price -->
                    <div class="border-b border-gray-100 pb-4">
                        <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $car->brand }} {{ $car->model }}</h1>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Brand (readonly) -->
                            <div>
                                <label for="brand" class="block text-sm font-medium text-gray-700">Merk</label>
                                <input type="text" id="brand" value="{{ $car->brand }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm" readonly>
                            </div>
                            
                            <!-- Model (readonly) -->
                            <div>
                                <label for="model" class="block text-sm font-medium text-gray-700">Model</label>
                                <input type="text" id="model" value="{{ $car->model }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm" readonly>
                            </div>
                            
                            <!-- Price (editable) -->
                            <div>
                                <label for="price" class="block text-sm font-medium text-gray-700">Prijs (€)</label>
                                <input type="number" name="price" id="price" step="0.01" value="{{ old('price', $car->price) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            </div>
                            
                            <!-- License Plate (readonly) -->
                            <div>
                                <label for="license_plate" class="block text-sm font-medium text-gray-700">Kenteken</label>
                                <input type="text" id="license_plate" value="{{ $car->license_plate }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm" readonly>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Stats -->
                    <div class="grid grid-cols-2 gap-4">
                        <!-- Production Year (readonly) -->
                        <div>
                            <label for="production_year" class="block text-sm font-medium text-gray-700">Bouwjaar</label>
                            <input type="number" id="production_year" value="{{ $car->production_year }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm" readonly>
                        </div>
                        
                        <!-- Mileage (editable) -->
                        <div>
                            <label for="mileage" class="block text-sm font-medium text-gray-700">Kilometerstand</label>
                            <input type="number" name="mileage" id="mileage" value="{{ old('mileage', $car->mileage) }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                        </div>
                        
                        <!-- Color (readonly) -->
                        <div>
                            <label for="color" class="block text-sm font-medium text-gray-700">Kleur</label>
                            <input type="text" id="color" value="{{ $car->color }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm" readonly>
                        </div>
                        
                        <!-- Weight (readonly) -->
                        <div>
                            <label for="weight" class="block text-sm font-medium text-gray-700">Gewicht (kg)</label>
                            <input type="number" id="weight" value="{{ $car->weight }}" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm" readonly>
                        </div>
                    </div>

                    <!-- Specifications (readonly) -->
                    <div class="space-y-4">
                        <h2 class="text-xl font-bold text-gray-900">Specificaties</h2>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Aantal deuren</label>
                                <div class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm p-2">
                                    {{ $car->doors }}
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Zitplaatsen</label>
                                <div class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm p-2">
                                    {{ $car->seats }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Tags (editable) -->
                    <div class="space-y-2">
                        <h2 class="text-xl font-bold text-gray-900">Kenmerken</h2>
                        <div class="flex flex-wrap gap-2">
                            @foreach($allTags as $tag)
                                <div class="inline-flex items-center">
                                    <input type="checkbox" name="tags[]" id="tag-{{ $tag->id }}" value="{{ $tag->id }}" 
                                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                           {{ in_array($tag->id, $car->tags->pluck('id')->toArray()) ? 'checked' : '' }}>
                                    <label for="tag-{{ $tag->id }}" class="ml-2 text-sm text-gray-700">{{ $tag->name }}</label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    
                    <!-- Sold Status (editable) -->
                    <div class="space-y-2">
                        <h2 class="text-xl font-bold text-gray-900">Verkoopstatus</h2>
                        <div class="flex items-center">
                            <input type="checkbox" name="sold" id="sold" value="1" 
                                class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50"
                                {{ $car->sold_at ? 'checked' : '' }}>
                            <label for="sold" class="ml-2 text-sm text-gray-700">Auto is verkocht</label>
                        </div>
                        
                        <!-- Only show if car is sold -->
                        @if($car->sold_at)
                        <div class="mt-2">
                            <label class="block text-sm font-medium text-gray-700">Verkocht op</label>
                            <div class="mt-1 block w-full rounded-md border-gray-300 shadow-sm bg-gray-100 sm:text-sm p-2">
                                {{ $car->sold_at->format('d-m-Y H:i') }}
                            </div>
                        </div>
                        @endif
                    </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions -->
            <div class="bg-gray-50 px-6 py-4 border-t border-gray-200 flex justify-between">
                <a href="{{ route('cars.my-cars') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Annuleren
                </a>
                <button type="submit" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Opslaan
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    // Image handling functions (existing)
    function removeImage(button, index) {
        const removedInput = document.getElementById('removed_images');
        const currentRemoved = removedInput.value ? removedInput.value.split(',') : [];
        currentRemoved.push(index);
        removedInput.value = currentRemoved.join(',');
        button.parentElement.style.display = 'none';
    }

    document.getElementById('images').addEventListener('change', function(e) {
        const previewContainer = document.querySelector('.grid.grid-cols-3.gap-2');
        const files = e.target.files;
        
        for (let i = 0; i < files.length; i++) {
            const reader = new FileReader();
            reader.onload = function(event) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${event.target.result}" class="w-full h-24 object-cover rounded-lg">
                    <button type="button" onclick="this.parentElement.remove()" class="absolute top-1 right-1 bg-red-500 text-white rounded-full p-1 opacity-0 group-hover:opacity-100 transition-opacity">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                            <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                        </svg>
                    </button>
                `;
                previewContainer.appendChild(div);
            };
            reader.readAsDataURL(files[i]);
        }
    });

    // Sold status confirmation
    document.getElementById('sold').addEventListener('change', function(e) {
        if (this.checked) {
            if (!confirm('Weet u zeker dat u deze auto als verkocht wilt markeren?')) {
                this.checked = false;
            }
        }
    });
</script>
@endsection