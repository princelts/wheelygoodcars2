<nav class="bg-blue-600 shadow-md">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
        <!-- Logo -->
        <a class="text-2xl font-bold text-white" href="{{ url('/') }}">
            Wheely Good Cars
        </a>

        <!-- Navigation Links (Centered) -->
        <div class="hidden md:flex flex-grow justify-center text-white" id="navbar-menu">
            <ul class="flex space-x-6">
                <li><a class="hover:text-orange-400" href="{{ url('/cars') }}">Alle auto's</a></li>
                <li><a class="hover:text-orange-400" href="{{ url('/cars/my-cars') }}">Mijn aanbod</a></li>
                <li><a class="hover:text-orange-400" href="{{ url('/cars/create') }}">Aanbod plaatsen</a></li>
            </ul>
        </div>

        <!-- User Authentication (Right) -->
        <div class="hidden md:flex space-x-6">
            @guest
                @if (Route::has('login'))
                    <a class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:text-orange-400" href="{{ route('login') }}">
                        {{ __('Login') }}
                    </a>
                @endif
                @if (Route::has('register'))
                    <a class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:text-orange-400" href="{{ route('register') }}">
                        {{ __('Register') }}
                    </a>
                @endif
            @else
                <div class="relative">
                    <button class="bg-white text-blue-600 px-4 py-2 rounded-lg hover:text-orange-400" id="user-menu-toggle">
                        {{ Auth::user()->name }}
                    </button>
                    <div class="absolute right-0 mt-2 w-48 bg-white text-gray-800 shadow-lg rounded-md hidden" id="user-menu">
                        <a class="block px-4 py-2 hover:bg-gray-200" href="{{ route('logout') }}"
                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                            @csrf
                        </form>
                    </div>
                </div>
            @endguest
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="md:hidden text-white focus:outline-none" id="navbar-toggle">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
    </div>
</nav>

<script>
    document.getElementById('navbar-toggle').addEventListener('click', function() {
        document.getElementById('navbar-menu').classList.toggle('hidden');
    });
    document.getElementById('user-menu-toggle')?.addEventListener('click', function() {
        document.getElementById('user-menu').classList.toggle('hidden');
    });
</script>
