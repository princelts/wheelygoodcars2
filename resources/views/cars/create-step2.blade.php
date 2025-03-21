@extends('layouts.app')

@section('content')
<div class="container max-w-4xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold mb-6">Stap 2: Auto details</h2>

    <form action="{{ route('cars.create.step2', $licensePlate) }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label class="block text-gray-700 font-medium">Afbeeldingen (max 5)</label>
            <input type="file" name="images[]" multiple class="w-full px-4 py-2 border rounded-lg" accept="image/*" onchange="previewImages(event)">
            <p class="text-sm text-gray-500">Maximaal 5 afbeeldingen (jpg, jpeg, png).</p>
        </div>

        <!-- Image Preview -->
        <div id="imagePreviewContainer" class="flex gap-2 mt-4"></div>

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

        <div class="mt-4">
            <label class="block text-gray-700 font-medium">Kilometerstand</label>
            <input type="number" name="mileage" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
        </div>

        <div class="mt-4">
            <label class="block text-gray-700 font-medium">Vraagprijs</label>
            <input type="text" name="price" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
        </div>

        <button type="submit" class="mt-6 bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">
            Aanbod afronden
        </button>
    </form>
</div>

<script>
function previewImages(event) {
    let container = document.getElementById('imagePreviewContainer');
    container.innerHTML = ''; // Clear previous previews
    
    let files = event.target.files;
    if (files.length > 5) {
        alert('Je mag maximaal 5 afbeeldingen uploaden.');
        event.target.value = ''; // Reset input
        return;
    }

    for (let i = 0; i < files.length; i++) {
        let reader = new FileReader();
        let img = document.createElement('img');
        
        img.classList.add('h-30', 'rounded-lg', 'object-cover', 'shadow-md', 'w-1/4'); // Add width and styling
        
        reader.onload = function(e) {
            img.src = e.target.result;
        };
        
        reader.readAsDataURL(files[i]);
        container.appendChild(img);
    }
}
</script>

@endsection
