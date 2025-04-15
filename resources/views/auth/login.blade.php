@extends('layouts.app')

@section('content')
<div class="mx-auto max-w-md mt-10 bg-white p-8 rounded-xl shadow-md border border-blue-100">
        <h2 class="text-center text-3xl font-bold text-gray-800 mb-6">Inloggen</h2>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div class="mb-4">
            <label for="email" class="block text-sm font-semibold text-gray-600 mb-1">E-mailadres</label>
            <input id="email" type="email" 
                class="w-full border border-gray-300 p-3 rounded-lg @error('email') border-red-500 @enderror" 
                name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>

            @error('email')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="mb-4">
            <label for="password" class="block text-sm font-semibold text-gray-600 mb-1">Wachtwoord</label>
            <input id="password" type="password" 
                class="w-full border border-gray-300 p-3 rounded-lg @error('password') border-red-500 @enderror" 
                name="password" required autocomplete="current-password">

            @error('password')
                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="mb-4 flex items-center">
            <input class="mr-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
            <label class="text-sm text-gray-700" for="remember">Onthoud mij</label>
        </div>

        <!-- Submit Button -->
        <div class="flex justify-between items-center">
            <button type="submit"                        class="w-full bg-white text-blue-600 border border-blue-600 py-2 rounded font-semibold hover:bg-blue-600 hover:text-white transition">
                Inloggen
            </button>
        </div>
                    @if (Route::has('password.request'))
            <div class="mt-4 text-center">

                <a class="text-sm text-blue-600 hover:underline" href="{{ route('password.request') }}">
                    Wachtwoord vergeten?
                </a>
            </div>
            @endif
    </form>
</div>
@endsection
