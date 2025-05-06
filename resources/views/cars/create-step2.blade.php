@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto p-6 bg-white rounded-xl shadow-md">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex justify-between mb-2">
            <span class="text-blue-600 font-medium">Stap 2 van 3</span>
            <span class="text-gray-500">50% voltooid</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 50%"></div>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-6">Auto details</h2>
{{-- 
    @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-lg">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
                <h3 class="text-red-800 font-medium">Er zijn fouten gevonden:</h3>
            </div>
            <ul class="mt-2 list-disc list-inside text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif --}}

    <form action="{{ route('cars.create.step2', $licensePlate) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <!-- Image Upload -->
        <div>
            <label class="block text-gray-700 font-medium mb-2">Afbeeldingen (max 5)</label>
            <div class="flex items-center justify-center w-full">
                <label for="images" class="flex flex-col w-full h-32 border-2 {{ $errors->has('images') ? 'border-red-500' : 'border-dashed border-gray-300' }} rounded-lg cursor-pointer hover:border-blue-500 transition">
                    <div class="flex flex-col items-center justify-center pt-7">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-10 h-10 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="pt-1 text-sm text-gray-500">Klik om afbeeldingen te uploaden</p>
                    </div>
                    <input id="images" name="images[]" type="file" multiple class="opacity-0" accept="image/*" onchange="previewImages(event)">
                </label>
            </div>
            @error('images')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            @error('images.*')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
            <p class="mt-1 text-sm text-gray-500">Maximaal 5 afbeeldingen (jpg, jpeg, png)</p>
            
            <!-- Image Preview -->
            <div id="imagePreviewContainer" class="flex flex-wrap gap-4 mt-4"></div>
        </div>

        <!-- Car Details Grid -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-gray-700 font-medium">Kenteken</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100" value="{{ session('license_plate') }}" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Merk</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100" value="{{ session('brand') }}" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Model</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100" value="{{ session('model') }}" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Bouwjaar</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100" value="{{ session('production_year') }}" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Kleur</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100" value="{{ session('color') }}" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Aantal deuren</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100" value="{{ session('doors') }}" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Zitplaatsen</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100" value="{{ session('seats') }}" readonly>
            </div>
            <div>
                <label class="block text-gray-700 font-medium">Gewicht</label>
                <input type="text" class="w-full px-4 py-2 border rounded-lg bg-gray-100" value="{{ session('weight') }}" readonly>
            </div>
        </div>

                <!-- Editable Fields -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label for="mileage" class="block text-gray-700 font-medium mb-2">Kilometerstand</label>
                <div class="relative">
                    <input id="mileage" name="mileage" 
                           class="w-full px-4 py-3 border {{ $errors->has('mileage') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           value="{{ old('mileage') }}"
                           required>
                    <span class="absolute right-4 top-3 text-gray-500">km</span>
                </div>
                @error('mileage')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label for="price" class="block text-gray-700 font-medium mb-2">Vraagprijs</label>
                <div class="relative">
                    <span class="absolute left-4 top-3 text-gray-500">€</span>
                    <input type="text" id="price" name="price" 
                           class="w-full pl-10 pr-4 py-3 border {{ $errors->has('price') ? 'border-red-500' : 'border-gray-300' }} rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                           value="{{ old('price') }}"
                           required>
                </div>
                @error('price')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
                <!-- Grouped Tags Section -->
        {{-- <div class="mt-6">
            <label class="block text-gray-700 font-medium mb-3">Kenmerken</label>
            
            @foreach($tagGroups as $group => $tags)
            <div class="mb-6">
                <h4 class="font-medium text-gray-700 mb-3">{{ $group }}</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <div class="flex items-center">
                            <input type="checkbox" id="tag-{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}" 
                                   class="hidden peer"
                                   @if(in_array($tag->id, old('tags', []))) checked @endif>
                            <label for="tag-{{ $tag->id }}" 
                                   class="px-4 py-2 border border-gray-300 rounded-full text-sm cursor-pointer 
                                          peer-checked:bg-blue-100 peer-checked:border-blue-500 peer-checked:text-blue-800
                                          hover:bg-gray-100 transition">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
            </div>
            @endforeach
        </div> --}}


        <div class="flex justify-between pt-6 border-t">
            <a href="{{ route('cars.create') }}" class="px-6 py-3 text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Vorige
            </a>
            <button type="submit" 
                    class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition flex items-center">
                Volgende
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10.293 5.293a1 1 0 011.414 0l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414-1.414L12.586 11H5a1 1 0 110-2h7.586l-2.293-2.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </form>
</div>

<script>
function previewImages(event) {
    const container = document.getElementById('imagePreviewContainer');
    container.innerHTML = '';
    
    const files = event.target.files;
    if (files.length > 5) {
        alert('Je mag maximaal 5 afbeeldingen uploaden.');
        event.target.value = '';
        return;
    }

    Array.from(files).forEach(file => {
        if (!file.type.match('image.*')) return;
        
        const reader = new FileReader();
        const previewDiv = document.createElement('div');
        previewDiv.className = 'relative w-32 h-32 rounded-lg overflow-hidden shadow-md';
        
        const img = document.createElement('img');
        img.className = 'w-full h-full object-cover';
        
        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '×';
        removeBtn.className = 'absolute top-1 right-1 bg-red-500 text-white rounded-full w-6 h-6 flex items-center justify-center opacity-0 hover:opacity-100 transition';
        removeBtn.onclick = (e) => {
            e.preventDefault();
            previewDiv.remove();
            updateFileInput(files, file);
        };
        
        reader.onload = (e) => {
            img.src = e.target.result;
            previewDiv.appendChild(img);
            previewDiv.appendChild(removeBtn);
            container.appendChild(previewDiv);
        };
        
        reader.readAsDataURL(file);
    });
}

function updateFileInput(allFiles, fileToRemove) {
    const dt = new DataTransfer();
    Array.from(allFiles).forEach(file => {
        if (file !== fileToRemove) {
            dt.items.add(file);
        }
    });
    document.getElementById('images').files = dt.files;
}
</script>
@endsection