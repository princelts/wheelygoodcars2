@extends('layouts.app')

@section('content')
<div class="flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full bg-white p-8 rounded-lg shadow-md border border-blue-100">
        <h2 class="text-center text-3xl font-bold text-gray-800 mb-6">Account aanmaken</h2>

        <form method="POST" action="{{ route('register') }}" class="space-y-4">
            @csrf

            <!-- Naam -->
            <div>
                <label for="name" class="block text-sm font-medium text-gray-700">Naam</label>
                <input id="name" type="text" name="name" value="{{ old('name') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('name') border-red-500 @enderror"
                       required autocomplete="name" autofocus>

                @error('name')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Email -->
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('email') border-red-500 @enderror"
                       required autocomplete="email">

                @error('email')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Wachtwoord -->
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">Wachtwoord</label>
                <input id="password" type="password" name="password"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('password') border-red-500 @enderror"
                       required autocomplete="new-password">

                @error('password')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            <!-- Bevestig wachtwoord -->
            <div>
                <label for="password-confirm" class="block text-sm font-medium text-gray-700">Bevestig wachtwoord</label>
                <input id="password-confirm" type="password" name="password_confirmation"
                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                       required autocomplete="new-password">
            </div>

            <!-- Register knop -->
            <div>
                <button type="submit"
                        class="w-full bg-white text-blue-600 border border-blue-600 py-2 rounded font-semibold hover:bg-blue-600 hover:text-white transition">
                    Account aanmaken
                </button>
            </div>
        </form>

        <!-- Login link -->
        <div class="mt-4 text-center">
            <p class="text-sm text-gray-600">
                Heb je al een account? 
                <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-800 font-semibold">
                    Inloggen
                </a>
            </p>
        </div>
    </div>
</div>
@endsection
