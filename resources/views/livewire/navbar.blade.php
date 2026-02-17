<nav x-data="{ mobileOpen: false, companyOpen: false, mobileCompanyOpen: false }" class="pointer-events-none fixed inset-x-0 top-0 z-40 h-auto pt-6">
    <div class="mx-auto px-4">

        {{-- MAIN BAR --}}
        <div
            class="pointer-events-auto flex items-center justify-between rounded-full border border-gray-200 bg-white/90 px-5 py-3 shadow-md backdrop-blur">

            {{-- LOGO --}}
            <a href="/" class="flex items-center gap-2">
                <img src="{{ asset('images/Logo.png') }}" alt="logo" class="h-8 w-auto">
            </a>

            {{-- DESKTOP MENU --}}
            <div class="relative hidden items-center gap-8 text-sm font-medium md:flex">
                <a href="/"
                    class="{{ request()->routeIs('home') ? 'text-brand' : 'text-gray-700 hover:text-brand' }} rounded-full px-3 py-1.5 transition">
                    Beranda
                </a>

                {{-- COMPANY --}}
                <div class="relative" @click.outside="companyOpen = false">
                    <button @click="companyOpen = !companyOpen"
                        class="{{ request()->routeIs('residence-list', 'property-list', 'article-list', 'testimonials', 'customer-feedback')
                            ? 'text-brand'
                            : 'text-gray-700 hover:text-blue-600' }} flex items-center gap-1">
                        Menu
                        <svg :class="companyOpen ? 'rotate-180' : ''" class="h-4 w-4 transition-transform duration-200"
                            fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="companyOpen" x-transition:enter="transition ease-out duration-200"
                        x-transition:enter-start="opacity-0 -translate-y-2 scale-95"
                        x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                        x-transition:leave="transition ease-in duration-150"
                        x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                        x-transition:leave-end="opacity-0 -translate-y-2 scale-95"
                        class="absolute mt-3 w-48 origin-top overflow-hidden rounded-xl border bg-white shadow-lg"
                        style="display: none;">

                        @php
                            $dropdownClass = 'block px-4 py-2 text-sm transition';
                            $activeClass = 'text-blue-600 font-semibold';
                            $inactiveClass = 'text-gray-700 hover:bg-gray-100 hover:text-brand';
                        @endphp

                        <a href="{{ route('project-list') }}"
                            class="{{ $dropdownClass }} {{ request()->routeIs('project-list') ? $activeClass : $inactiveClass }}">
                            Proyek
                        </a>
                        <a href="{{ route('article-list') }}"
                            class="{{ $dropdownClass }} {{ request()->routeIs('article-list') ? $activeClass : $inactiveClass }}">
                            Artikel
                        </a>
                        <a href="{{ route('testimonials') }}"
                            class="{{ $dropdownClass }} {{ request()->routeIs('testimonials') ? $activeClass : $inactiveClass }}">
                            Testimoni
                        </a>
                        <a href="{{ route('customer-feedback') }}"
                            class="{{ $dropdownClass }} {{ request()->routeIs('customer-feedback') ? $activeClass : $inactiveClass }}">
                            Umpan Balik Pelanggan
                        </a>
                    </div>
                </div>

                <a href="{{ route('about') }}"
                    class="{{ request()->routeIs('about') ? 'text-brand' : 'text-gray-700 hover:text-blue-600' }}">
                    Tentang Kami
                </a>
            </div>

            {{-- DESKTOP CTA --}}
            <a href="{{ route('contact') }}"
                class="hidden rounded-full bg-blue-600 px-5 py-2 text-sm font-medium text-white transition hover:bg-blue-700 hover:opacity-90 md:inline-block">
                Hubungi Kami
            </a>

            {{-- MOBILE TOGGLE BUTTON --}}
            <button @click="mobileOpen = !mobileOpen"
                class="flex h-10 w-10 items-center justify-center rounded-full hover:bg-gray-100 md:hidden">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        {{-- MOBILE MENU CONTAINER --}}
        <div x-show="mobileOpen" @click.outside="mobileOpen = false"
            x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 -translate-y-4 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-4 scale-95"
            class="pointer-events-auto mt-3 origin-top overflow-hidden rounded-2xl border border-gray-200 bg-white/95 shadow-md backdrop-blur md:hidden"
            style="display: none;">

            <a href="/"
                class="{{ request()->routeIs('home') ? 'text-blue-600' : 'hover:bg-gray-100' }} block px-6 py-4">
                Beranda
            </a>

            {{-- MOBILE COMPANY TOGGLE --}}
            <button @click="mobileCompanyOpen = !mobileCompanyOpen"
                class="flex w-full items-center justify-between px-6 py-4">
                <span>Menu</span>
                <svg :class="mobileCompanyOpen ? 'rotate-180' : ''" class="h-4 w-4 transition-transform duration-200"
                    fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            {{-- MOBILE COMPANY SUBMENU --}}
            <div x-show="mobileCompanyOpen" x-transition:enter="transition-all ease-out duration-300"
                x-transition:enter-start="opacity-0 max-h-0" x-transition:enter-end="opacity-100 max-h-96"
                x-transition:leave="transition-all ease-in duration-200" x-transition:leave-start="opacity-100 max-h-96"
                x-transition:leave-end="opacity-0 max-h-0" class="w-full overflow-hidden bg-gray-50 px-6"
                style="display: none;">

                <a href="{{ route('project-list') }}"
                    class="{{ request()->routeIs('project-list') ? 'text-blue-600' : 'hover:bg-gray-100' }} mt-2 block px-4 py-2">
                    Proyek
                </a>
                <a href="{{ route('article-list') }}"
                    class="{{ request()->routeIs('article-list') ? 'text-blue-600' : 'hover:bg-gray-100' }} block px-4 py-2">
                    Artikel
                </a>
                <a href="{{ route('testimonials') }}"
                    class="{{ request()->routeIs('testimonials') ? 'text-blue-600' : 'hover:bg-gray-100' }} block px-4 py-2">
                    Testimoni
                </a>
                <a href="{{ route('customer-feedback') }}"
                    class="{{ request()->routeIs('customer-feedback') ? 'text-blue-600' : 'hover:bg-gray-100' }} mb-2 block px-4 py-2">
                    Umpan Balik Pelanggan
                </a>
            </div>

            <a href="{{ route('about') }}"
                class="{{ request()->routeIs('about') ? 'text-blue-600' : 'hover:bg-gray-100' }} block px-6 py-4">
                Tentang Kami
            </a>

            <div class="px-6 py-4">
                <a href="{{ route('contact') }}" class="bg-brand block rounded-full py-2 text-center text-white">
                    Hubungi Kami
                </a>
            </div>
        </div>

    </div>
</nav>
