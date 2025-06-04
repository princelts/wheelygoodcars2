<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Car;
use App\Models\Tag;
use Illuminate\Support\Facades\Log;

class CarController extends Controller
{
    public function createStep1()
    {
        return view('cars.create-step1');
    }

    public function storeStep1(Request $request)
    {
        $validated = $request->validate([
            'license_plate' => [
                'required',
                'unique:cars,license_plate',
                'regex:/^[A-Z0-9]{1,3}-?[A-Z0-9]{1,3}-?[A-Z0-9]{1,3}$/i'
            ],
        ], [
            'license_plate.required' => 'Kenteken is verplicht',
            'license_plate.unique' => 'Dit kenteken bestaat al in ons systeem',
            'license_plate.regex' => 'Voer een geldig Nederlands kenteken in (bijv. AB-123-C of 12-ABC-3)',
        ]);

        // Clean and format license plate
        $licensePlate = strtoupper(str_replace('-', '', $request->license_plate));

        // RDW API-call
        $response = Http::get("https://opendata.rdw.nl/resource/m9d7-ebf2.json?kenteken=" . $licensePlate);
        $carData = $response->json();

        if (empty($carData)) {
            return back()->withErrors(['license_plate' => 'Kenteken niet gevonden in RDW database.']);
        }

        $car = $carData[0];

        session([
            'license_plate' => $licensePlate,
            'brand' => $car['merk'] ?? 'Onbekend',
            'model' => $car['handelsbenaming'] ?? 'Onbekend',
            'production_year' => substr($car['datum_eerste_toelating'] ?? '', 0, 4) ?: 'Onbekend',
            'color' => $car['eerste_kleur'] ?? 'Onbekend',
            'doors' => $car['aantal_deuren'] ?? 'Onbekend',
            'seats' => $car['aantal_zitplaatsen'] ?? 'Onbekend',
            'weight' => $car['massa_rijklaar'] ?? 'Onbekend',
        ]);

        return redirect()->route('cars.create.step2', $licensePlate);
    }

    public function createStep2($licensePlate)
    {
        $tagGroups = Tag::orderBy('group')
                       ->orderBy('name')
                       ->get()
                       ->groupBy('group');

        return view('cars.create-step2', compact('licensePlate', 'tagGroups'));
    }

    public function storeStep2(Request $request, $licensePlate)
    {
        $validated = $request->validate([
            'mileage' => 'required|integer|min:0|max:1000000',
            'price' => 'required|numeric|min:500|max:500000',
            'images' => 'required|array|min:1|max:5',
            'images.*' => 'image|mimes:jpg,jpeg,png|max:2048',
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ], [
            'mileage.required' => 'Kilometerstand is verplicht',
            'mileage.integer' => 'Voer een geldig aantal kilometers in',
            'mileage.min' => 'Kilometerstand moet minimaal 0 km zijn',
            'mileage.max' => 'Kilometerstand mag maximaal 1.000.000 km zijn',
            'price.required' => 'Prijs is verplicht',
            'price.numeric' => 'Voer een geldig bedrag in',
            'price.min' => 'Prijs moet minimaal €500 zijn',
            'price.max' => 'Prijs mag maximaal €500.000 zijn',
            'images.required' => 'Upload minimaal 1 afbeelding',
            'images.min' => 'Upload minimaal 1 afbeelding',
            'images.max' => 'Maximaal 5 afbeeldingen toegestaan',
            'images.*.image' => 'Bestand moet een afbeelding zijn',
            'images.*.mimes' => 'Alleen JPG, JPEG of PNG afbeeldingen toegestaan',
            'images.*.max' => 'Afbeelding mag maximaal 2MB groot zijn',
            'tags.*.exists' => 'Ongeldige tag geselecteerd',
        ]);

        // Store the images
        $imagePaths = [];
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('cars', 'public');
                $imagePaths[] = $path;
            }
        }


        session([
            'car_data' => [
                'mileage' => $request->mileage,
                'price' => $request->price,
                'brand' => $request->brand,
                'model' => $request->model,
                'production_year' => $request->production_year,
                'color' => $request->color,
                'doors' => $request->doors,
                'seats' => $request->seats,
                'weight' => $request->weight,
                'images' => $imagePaths,
                // Andere velden uit sessie
            ]
        ]);

        return redirect()->route('cars.create.step3', $licensePlate);

    }

    public function createStep3($licensePlate)
    {
        $tagGroups = Tag::orderBy('group')
                       ->orderBy('name')
                       ->get()
                       ->groupBy('group');

        return view('cars.create-step3', compact('licensePlate', 'tagGroups'));
    }

    public function storeStep3(Request $request, $licensePlate)
    {
        $request->validate([
            'tags' => 'nullable|array',
            'tags.*' => 'exists:tags,id',
        ]);

        $carData = session('car_data');
        
        $car = Car::create([
            'user_id' => Auth::id(),
            'license_plate' => session('license_plate'),
            'brand' => session('brand'),
            'model' => session('model'),
            'production_year' => session('production_year'),
            'color' => session('color'),
            'doors' => (int) session('doors'),
            'seats' => (int) session('seats'),
            'weight' => (int) session('weight'),
            'mileage' => $carData['mileage'],
            'price' => $carData['price'],
            'images' => json_encode($carData['images']),
        ]);

        if ($request->has('tags')) {
            $car->tags()->attach($request->tags);
        }

        // Sessie opschonen
        $request->session()->forget([
            'license_plate', 'brand', 'model', 'production_year',
            'color', 'doors', 'seats', 'weight', 'car_data'
        ]);

        return redirect()->route('cars.my-cars')
            ->with('success', 'Auto succesvol toegevoegd!');
    }


    public function myCars()
    {
        $myCars = Auth::user()->cars()->with('tags')->paginate(10);
        return view('cars.my-cars', compact('myCars'));
    }

    public function searchResults(Request $request)
    {
        $query = Car::query()->where('sold_at', null);

        // Search query
        if ($request->filled('query')) {
            $searchTerm = $request->input('query');
            $query->where(function($q) use ($searchTerm) {
                $q->where('brand', 'like', "%{$searchTerm}%")
                  ->orWhere('model', 'like', "%{$searchTerm}%")
                  ->orWhere('color', 'like', "%{$searchTerm}%");
            });
        }

        // Filters
        if ($request->filled('brand')) {
            $query->where('brand', $request->input('brand'));
        }
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }
        if ($request->filled('min_year')) {
            $query->where('production_year', '>=', $request->input('min_year'));
        }
        if ($request->filled('max_year')) {
            $query->where('production_year', '<=', $request->input('max_year'));
        }
        if ($request->filled('min_mileage')) {
            $query->where('mileage', '>=', $request->input('min_mileage'));
        }
        if ($request->filled('max_mileage')) {
            $query->where('mileage', '<=', $request->input('max_mileage'));
        }
        if ($request->filled('tags')) {
            $query->whereHas('tags', function($q) use ($request) {
                $q->whereIn('tags.id', $request->input('tags'));
            });
        }

        $brands = Car::select('brand')->distinct()->orderBy('brand')->pluck('brand');
        $tagGroups = Tag::orderBy('group')
                       ->orderBy('name')
                       ->get()
                       ->groupBy('group');
        
        $cars = $query->paginate(12);
        $totalCars = $cars->total();

        return view('cars.search-results', compact('cars', 'totalCars', 'brands', 'tagGroups'));
    }

    public function show($id)
    {
        $car = Car::with('tags')->findOrFail($id);
        $car->increment('views');
        return view('cars.show', compact('car'));
    }
public function edit(Car $car)
{
            $car = Car::where('id', $car->id)
                 ->where('user_id', Auth::id())
                 ->firstOrFail();
    // Direct authorization check without Policy
    if ($car->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }
    
    $allTags = Tag::all();
    return view('cars.edit', [
        'car' => $car,
        'allTags' => $allTags
    ]);
}

public function update(Request $request, Car $car)
{
    // Direct authorization check
    if ($car->user_id !== auth()->id()) {
        abort(403, 'Unauthorized action.');
    }

    $validated = $request->validate([
        'price' => 'required|numeric|min:0',
        'mileage' => 'required|integer|min:0',
        'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
        'tags' => 'nullable|array',
        'tags.*' => 'exists:tags,id',
    ]);

    // Handle images
    $currentImages = $car->images ? json_decode($car->images) : [];
    $removedImages = $request->removed_images ? explode(',', $request->removed_images) : [];

    // Filter out removed images
    $updatedImages = array_filter($currentImages, function($index) use ($removedImages) {
        return !in_array($index, $removedImages);
    }, ARRAY_FILTER_USE_KEY);

    // Add new images
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            $path = $image->store('car_images', 'public');
            $updatedImages[] = $path;
        }
    }

    // Update only allowed fields
    $car->update([
        'price' => $validated['price'],
        'mileage' => $validated['mileage'],
        'images' => !empty($updatedImages) ? json_encode(array_values($updatedImages)) : null,
    ]);

    // Sync tags if provided
    $car->tags()->sync($validated['tags'] ?? []);

    return redirect()->route('cars.my-cars')->with('success', 'Auto succesvol bijgewerkt!');
}


    public function destroy($id)
    {
        $car = Car::where('id', $id)
                 ->where('user_id', Auth::id())
                 ->firstOrFail();
        $car->delete();

        return redirect()->route('cars.my-cars')
            ->with('success', 'Auto verwijderd.');
    }
}