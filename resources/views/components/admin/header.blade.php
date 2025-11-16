<header class="flex items-center justify-between px-6 py-4 bg-white border-b-2 border-gray-200">
    <div class="flex items-center">
        <button @click="sidebarOpen = !sidebarOpen" class="text-gray-500 focus:outline-none">
            <svg class="w-6 h-6 me-5" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M4 6H20M4 12H20M4 18H11" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
        </button>

        {{-- <div class="relative mx-4 lg:mx-0">
            <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                <svg class="w-5 h-5 text-gray-500" viewBox="0 0 24 24" fill="none">
                    <path d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                </svg>
            </span>
            <input class="w-32 pl-10 pr-4 form-input rounded-md sm:w-64 focus:border-green-400 focus:ring focus:ring-green-200 focus:ring-opacity-50" type="text" placeholder="Search">
        </div> --}}
    </div>

    <div class="flex items-center">
        <div x-data="{ dropdownOpen: false }" class="relative">
            <button @click="dropdownOpen = ! dropdownOpen" class="relative block w-8 h-8 overflow-hidden rounded-full shadow focus:outline-none">
                {{-- Menggunakan nama user yang sedang login untuk avatar --}}
                <img class="object-cover w-full h-full" src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=028579&color=fff" alt="Your avatar">
            </button>

            <div x-show="dropdownOpen" @click.away="dropdownOpen = false" class="absolute right-0 w-48 mt-2 overflow-hidden bg-white rounded-md shadow-xl z-10" x-transition>
                {{-- Form untuk Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       class="block px-4 py-2 text-sm text-gray-700 hover:bg-[#028579]  hover:text-white">
                        Log Out
                    </a>
                </form>
            </div>
        </div>
    </div>
</header>
