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

<!-- Phone Number -->
<div>
    <label for="phone" class="block text-sm font-medium text-gray-700">Telefoonnummer</label>
    <input id="phone_number" type="tel" name="phone" value="{{ old('phone') }}"
           class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2 @error('phone') border-red-500 @enderror"
           required autocomplete="tel">
           <div id="phone-valid-msg" class="hidden text-green-600 text-sm mt-1">Geldig nummer ✔️</div>
<div id="phone-error-msg" class="hidden text-red-500 text-sm mt-1">Ongeldig telefoonnummer ❌</div>

    <p class="mt-1 text-sm text-gray-500">Selecteer je land en voer je nummer in</p>
    @error('phone')
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
</div><!-- intl-tel-input CSS (zet dit in je layout als je wilt) -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.min.css"/>

<!-- intl-tel-input JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js"></script>
<script>
    const phoneInput = document.querySelector("#phone_number");
    const validMsg = document.querySelector("#phone-valid-msg");
    const errorMsg = document.querySelector("#phone-error-msg");

    const iti = window.intlTelInput(phoneInput, {
        initialCountry: "nl",
        nationalMode: true,
        separateDialCode: true,
        autoPlaceholder: "aggressive",
        autoHideDialCode: false,
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.19/js/utils.min.js"
    });

    const form = phoneInput.closest("form");

    let fullPhoneInput = document.querySelector("input[name='full_phone']");
    if (!fullPhoneInput) {
        fullPhoneInput = document.createElement("input");
        fullPhoneInput.type = "hidden";
        fullPhoneInput.name = "full_phone";
        form.appendChild(fullPhoneInput);
    }

    const resetValidation = () => {
        validMsg.classList.add("hidden");
        errorMsg.classList.add("hidden");
        phoneInput.classList.remove("border-green-500", "border-red-500");
    };

    const isManualCountryCode = (value) => {
        return value.trim().startsWith("+") || value.trim().startsWith("00");
    };

    const showValidation = () => {
        resetValidation();
        const value = phoneInput.value.trim();

        if (!value) return;

        if (isManualCountryCode(value)) {
            phoneInput.classList.add("border-red-500");
            errorMsg.textContent = "Voer alleen je lokale nummer in zonder landcode";
            errorMsg.classList.remove("hidden");
            return;
        }

        if (iti.isValidNumber()) {
            phoneInput.classList.add("border-green-500");
            validMsg.classList.remove("hidden");
        } else {
            phoneInput.classList.add("border-red-500");
            errorMsg.textContent = "Ongeldig telefoonnummer ❌";
            errorMsg.classList.remove("hidden");
        }
    };

    phoneInput.addEventListener('input', showValidation);
    phoneInput.addEventListener('blur', showValidation);

    form.addEventListener("submit", function (e) {
        const value = phoneInput.value.trim();

        if (isManualCountryCode(value)) {
            e.preventDefault();
            resetValidation();
            phoneInput.classList.add("border-red-500");
            errorMsg.textContent = "Voer alleen je lokale nummer in zonder landcode";
            errorMsg.classList.remove("hidden");
            return;
        }

        if (!iti.isValidNumber()) {
            e.preventDefault();
            resetValidation();
            phoneInput.classList.add("border-red-500");
            errorMsg.textContent = "Ongeldig telefoonnummer ❌";
            errorMsg.classList.remove("hidden");
            return;
        }

        fullPhoneInput.value = iti.getNumber(); // E.164 formaat
    });
</script>

@endsection