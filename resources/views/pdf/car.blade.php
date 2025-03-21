<!DOCTYPE html>
<html>
<head>
    <title>Auto Details</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-lg p-6">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Auto Details</h1>
        </div>

        <div class="mb-6 text-center">
            @if($car->image)
                <img src="{{ public_path('storage/' . $car->image) }}" alt="Auto Afbeelding" class="mx-auto rounded-lg shadow-md">
            @else
                <p class="text-gray-500">Geen afbeelding beschikbaar</p>
            @endif
        </div>

        <div class="mb-6">
            <table class="w-full border-collapse">
                <tr class="border-b">
                    <th class="p-3 text-left bg-gray-100">Kenteken</th>
                    <td class="p-3">{{ $car->license_plate }}</td>
                </tr>
                <tr class="border-b">
                    <th class="p-3 text-left bg-gray-100">Merk</th>
                    <td class="p-3">{{ $car->brand }}</td>
                </tr>
                <tr class="border-b">
                    <th class="p-3 text-left bg-gray-100">Model</th>
                    <td class="p-3">{{ $car->model }}</td>
                </tr>
                <tr class="border-b">
                    <th class="p-3 text-left bg-gray-100">Prijs</th>
                    <td class="p-3">€{{ number_format($car->price, 2, ',', '.') }}</td>
                </tr>
                <tr class="border-b">
                    <th class="p-3 text-left bg-gray-100">Kilometerstand</th>
                    <td class="p-3">{{ $car->mileage }} km</td>
                </tr>
                <tr class="border-b">
                    <th class="p-3 text-left bg-gray-100">Bouwjaar</th>
                    <td class="p-3">{{ $car->production_year }}</td>
                </tr>
                <tr class="border-b">
                    <th class="p-3 text-left bg-gray-100">Gewicht</th>
                    <td class="p-3">{{ $car->weight }} kg</td>
                </tr>
                <tr class="border-b">
                    <th class="p-3 text-left bg-gray-100">Kleur</th>
                    <td class="p-3">{{ $car->color }}</td>
                </tr>
                <tr class="border-b">
                    <th class="p-3 text-left bg-gray-100">Tags</th>
                    <td class="p-3">
                        @foreach($car->tags as $tag)
                            <span class="inline-block bg-gray-200 text-gray-700 px-2 py-1 rounded-full text-sm mr-2">{{ $tag->name }}</span>
                        @endforeach
                    </td>
                </tr>
            </table>
        </div>
    </div>
</body>
</html>