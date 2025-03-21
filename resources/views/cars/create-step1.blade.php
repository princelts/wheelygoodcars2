@extends('layouts.app')

@section('content')
<div class="container py-4 max-w-xl mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-xl font-bold mb-4">Stap 1: Kenteken invoeren</h2>
    <form action="{{ route('cars.create') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="license_plate" class="block text-gray-700 font-medium">Kenteken</label>
            <input type="text" id="license_plate" name="license_plate" class="w-full px-4 py-2 border rounded-lg focus:ring focus:ring-blue-300" required>
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Volgende</button>
    </form>
</div>
@endsection
