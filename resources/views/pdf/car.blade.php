<!DOCTYPE html>
<html>
<head>
    <title>{{ $car->brand }} {{ $car->model }} | {{ config('app.name') }}</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; line-height: 1.5; }
        .container { max-width: 800px; margin: 0 auto; }
        .header { background: #1e40af; color: white; padding: 1.5rem; }
        .badge { display: inline-block; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; font-weight: 600; }
        .sold { background: #dc2626; color: white; }
        .available { background: #059669; color: white; }
        .gallery { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; margin: 1.5rem 0; }
        .gallery img { width: 100%; height: 120px; object-fit: cover; border-radius: 0.5rem; }
        .price-box { background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 0.5rem; padding: 1rem; text-align: center; margin: 1.5rem 0; }
        .specs { display: grid; grid-template-columns: repeat(3, 1fr); gap: 0.75rem; margin: 1.5rem 0; }
        .spec-item { border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 0.75rem; }
        .spec-label { font-size: 0.875rem; color: #6b7280; margin-bottom: 0.25rem; }
        .spec-value { font-weight: 600; color: #111827; }
        .tags { display: flex; flex-wrap: wrap; gap: 0.5rem; margin: 1rem 0; }
        .tag { background: #e5e7eb; color: #374151; padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; }
        .footer { border-top: 1px solid #e5e7eb; padding: 1rem; text-align: center; color: #6b7280; font-size: 0.875rem; }
        .no-images { background: #f3f4f6; padding: 2rem; text-align: center; border-radius: 0.5rem; color: #6b7280; }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div>
                    <h1 style="margin: 0; font-size: 1.5rem; font-weight: 700;">{{ $car->brand }} {{ $car->model }}</h1>
                    <p style="margin: 0.25rem 0 0; font-size: 0.875rem; opacity: 0.9;">Kenteken: {{ $car->license_plate }}</p>
                </div>
                <div style="text-align: right;">
                    <span class="badge {{ $car->sold_at ? 'sold' : 'available' }}">
                        {{ $car->sold_at ? 'VERKOCHT' : 'BESCHIKBAAR' }}
                    </span>
                    @if($car->sold_at)
                    <p style="margin: 0.25rem 0 0; font-size: 0.75rem; opacity: 0.9;">Verkocht op: {{ $car->sold_at->format('d-m-Y') }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div style="padding: 1.5rem;">
            <!-- Image Gallery -->
            @php
                $images = is_string($car->images) ? json_decode($car->images) : ($car->images ?? []);
            @endphp
            
            @if(count($images) > 0)
                <div class="gallery">
                    @foreach(array_slice($images, 0, 3) as $image)
                        <img src="{{ storage_path('app/public/' . $image) }}" alt="Auto afbeelding">
                    @endforeach
                </div>
            @else
                <div class="no-images">
                    <p>Geen afbeeldingen beschikbaar</p>
                </div>
            @endif

            <!-- Price -->
            <div class="price-box">
                <p style="margin: 0 0 0.25rem; font-size: 0.875rem; color: #1e40af;">Vraagprijs</p>
                <p style="margin: 0; font-size: 1.75rem; font-weight: 700; color: #1e40af;">€{{ number_format($car->price, 2, ',', '.') }}</p>
            </div>

            <!-- Specifications -->
            <div class="specs">
                <div class="spec-item">
                    <p class="spec-label">Kilometerstand</p>
                    <p class="spec-value">{{ number_format($car->mileage, 0, ',', '.') }} km</p>
                </div>
                <div class="spec-item">
                    <p class="spec-label">Bouwjaar</p>
                    <p class="spec-value">{{ $car->production_year }}</p>
                </div>
                <div class="spec-item">
                    <p class="spec-label">Kleur</p>
                    <p class="spec-value">{{ $car->color }}</p>
                </div>
                <div class="spec-item">
                    <p class="spec-label">Gewicht</p>
                    <p class="spec-value">{{ $car->weight }} kg</p>
                </div>
                <div class="spec-item">
                    <p class="spec-label">Deuren</p>
                    <p class="spec-value">{{ $car->doors }}</p>
                </div>
                <div class="spec-item">
                    <p class="spec-label">Zitplaatsen</p>
                    <p class="spec-value">{{ $car->seats }}</p>
                </div>
            </div>

            <!-- Tags -->
            <h2 style="font-size: 1.125rem; font-weight: 600; margin: 1.5rem 0 0.5rem; color: #111827;">Kenmerken</h2>
            @if($car->tags->count() > 0)
                <div class="tags">
                    @foreach($car->tags as $tag)
                        <span class="tag">{{ $tag->name }}</span>
                    @endforeach
                </div>
            @else
                <p style="color: #6b7280; font-size: 0.875rem;">Geen kenmerken beschikbaar</p>
            @endif

            <!-- Metadata -->
            <div style="border-top: 1px solid #e5e7eb; padding-top: 1.5rem; margin-top: 1.5rem;">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div>
                        <p style="font-size: 0.875rem; color: #6b7280; margin: 0 0 0.25rem;">Aangemaakt</p>
                        <p style="font-weight: 500; margin: 0;">{{ $car->created_at->format('d-m-Y H:i') }}</p>
                    </div>
                    <div>
                        <p style="font-size: 0.875rem; color: #6b7280; margin: 0 0 0.25rem;">Bijgewerkt</p>
                        <p style="font-weight: 500; margin: 0;">{{ $car->updated_at->format('d-m-Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <div class="footer">
            {{ config('app.name') }} &bull; {{ date('d-m-Y H:i') }}
        </div>
    </div>
</body>
</html>