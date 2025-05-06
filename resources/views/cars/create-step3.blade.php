@extends('layouts.app')

@section('content')
<div class="max-w-2xl mx-auto p-6 bg-white rounded-xl shadow-md">
    <!-- Progress Bar -->
    <div class="mb-8">
        <div class="flex justify-between mb-2">
            <span class="text-blue-600 font-medium">Stap 3 van 3</span>
            <span class="text-gray-500">90% voltooid</span>
        </div>
        <div class="w-full bg-gray-200 rounded-full h-2.5">
            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 90%"></div>
        </div>
    </div>

    <h2 class="text-2xl font-bold mb-6">Kenmerken toevoegen</h2>

    <form action="{{ route('cars.create.step3', $licensePlate) }}" method="POST">
        @csrf

        <!-- Grouped Tags Section -->
        <div class="space-y-6">
            @foreach($tagGroups as $group => $tags)
            <div>
                <h4 class="font-medium text-gray-700 mb-3">{{ $group }}</h4>
                <div class="flex flex-wrap gap-2">
                    @foreach($tags as $tag)
                        <div class="flex items-center">
                            <input type="checkbox" id="tag-{{ $tag->id }}" name="tags[]" value="{{ $tag->id }}" 
                                   class="hidden peer">
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
        </div>

        <div class="flex justify-between pt-6 border-t mt-8">
            <a href="{{ route('cars.create.step2', $licensePlate) }}" class="px-6 py-3 text-gray-700 font-medium rounded-lg border border-gray-300 hover:bg-gray-50 transition flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
                Vorige
            </a>
            <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition flex items-center">
                Voltooien
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-2" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                </svg>
            </button>
        </div>
    </form>
</div>
@endsection