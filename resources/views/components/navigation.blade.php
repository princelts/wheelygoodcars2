<nav class="bg-white shadow-md border-b border-gray-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-20 items-center">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="{{ url('/') }}" class="flex items-center">
                    <svg class="h-8 w-8 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                    </svg>
                    <span class="ml-2 text-2xl font-bold text-gray-900">Wheely Good Cars</span>
                </a>
            </div>

            <!-- Navigation Links (Center) -->
            <div class="hidden md:flex md:items-center md:space-x-8">
                <a href="{{ url('/cars') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                    Alle auto's
                </a>
                <a href="{{ url('/cars/my-cars') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                    Mijn aanbod
                </a>
                <a href="{{ url('/cars/create') }}" class="px-3 py-2 rounded-md text-sm font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50 transition-colors duration-200">
                    Aanbod plaatsen
                </a>
            </div>

            <!-- User Authentication (Right) -->
            <div class="hidden z-20 md:flex md:items-center md:space-x-4">
                @guest
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-md text-sm font-medium text-blue-600 border border-blue-600 hover:bg-blue-600 hover:text-white transition-colors duration-200">
                            {{ __('Login') }}
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="px-4 py-2 rounded-md text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 transition-colors duration-200">
                            {{ __('Register') }}
                        </a>
                    @endif
                @else
                    <div class="relative ml-3">
                        <div>
                            <button id="user-menu-toggle" class="flex items-center text-sm rounded-full focus:outline-none">
                                <span class="sr-only">Open user menu</span>
                                <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span class="ml-2 text-gray-700">{{ Auth::user()->name }}</span>
                                <svg class="ml-1 h-4 w-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div id="user-menu" class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 hidden">
                            @if(Auth::user()->is_admin)
                                <a href="/admin" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                    Admin Dashboard
                                </a>
                            @endif
                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="block px-4 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600">
                                {{ __('Logout') }}
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                                @csrf
                            </form>
                        </div>
                    </div>
                @endguest
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button id="navbar-toggle" class="inline-flex items-center justify-center p-2 rounded-md text-gray-700 hover:text-blue-600 hover:bg-blue-50 focus:outline-none">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile menu -->
    <div id="navbar-menu" class="md:hidden hidden pb-3 px-4">
        <div class="pt-2 space-y-1">
            <a href="{{ url('/cars') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">
                Alle auto's
            </a>
            <a href="{{ url('/cars/my-cars') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">
                Mijn aanbod
            </a>
            <a href="{{ url('/cars/create') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">
                Aanbod plaatsen
            </a>
        </div>
        <div class="pt-4 border-t border-gray-200">
            @guest
                <div class="space-y-1">
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="block w-full px-3 py-2 rounded-md text-base font-medium text-blue-600 hover:bg-blue-50">
                            {{ __('Login') }}
                        </a>
                    @endif
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}" class="block w-full px-3 py-2 rounded-md text-base font-medium text-white bg-blue-600 hover:bg-blue-700">
                            {{ __('Register') }}
                        </a>
                    @endif
                </div>
            @else
                <div class="flex items-center px-3 py-2">
                    <div class="h-8 w-8 rounded-full bg-blue-600 flex items-center justify-center text-white font-medium">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </div>
                    <span class="ml-3 text-sm font-medium text-gray-700">{{ Auth::user()->name }}</span>
                </div>
                <div class="mt-1">
                    @if(Auth::user()->is_admin)
                        <a href="/admin" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">
                            Admin Dashboard
                        </a>
                    @endif
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form-mobile').submit();" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-blue-600 hover:bg-blue-50">
                        {{ __('Logout') }}
                    </a>
                    <form id="logout-form-mobile" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                </div>
            @endguest
        </div>
    </div>
</nav>

<script>
    document.getElementById('navbar-toggle').addEventListener('click', function() {
        document.getElementById('navbar-menu').classList.toggle('hidden');
    });
    
    const userMenuToggle = document.getElementById('user-menu-toggle');
    if (userMenuToggle) {
        userMenuToggle.addEventListener('click', function() {
            document.getElementById('user-menu').classList.toggle('hidden');
        });
    }

    // Close dropdown when clicking outside
    document.addEventListener('click', function(event) {
        const userMenu = document.getElementById('user-menu');
        if (userMenu && !userMenu.contains(event.target) && !event.target.matches('#user-menu-toggle, #user-menu-toggle *')) {
            userMenu.classList.add('hidden');
        }
    });
</script>