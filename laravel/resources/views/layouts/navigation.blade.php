
    @if(session('success'))
    <div id="message" class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-green-500 text-white px-6 py-4 rounded-lg shadow-lg opacity-100 transition-opacity duration-500">
        {{ session('success') }}
    </div>
    @endif

    @if($errors->any())

    <div id="message" class="fixed top-5 left-1/2 transform -translate-x-1/2 bg-red-500 text-white px-6 py-4 rounded-lg shadow-lg opacity-100 transition-opacity duration-500">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <nav x-data="{ open: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex h-16" style="justify-content: space-evenly;">
                <div class="flex">
                    <div class="hidden space-x-8 sm:-my-px sm:flex">
                        <x-nav-link :href="route('home')" :active="request()->routeIs('home')">
                            {{ __('Главная') }}
                        </x-nav-link>
                    </div>
                </div>
                <div class="flex">
                    <div class="hidden space-x-8 sm:-my-px sm:flex">
                        <x-nav-link :href="route('categories.index')" :active="request()->routeIs('categories.index')">
                            {{ __('Категории') }}
                        </x-nav-link>
                    </div>
                </div>

                @guest
                    <!-- Ссылки для входа и регистрации -->
                    <div class="flex">
                        <div class="hidden space-x-8 sm:-my-px sm:flex">
                            <x-nav-link href="{{ route('login') }}" class="text-gray-800 dark:text-white hover:underline">Войти</x-nav-link>
                            <x-nav-link  href="{{ route('register') }}" class="text-gray-800 dark:text-white hover:underline">Зарегистрироваться</x-nav-link>
                        </div>
                    </div>
                @endguest

                @auth

                    <div class="flex">
                        <!-- Navigation Links -->
                        <div class="hidden space-x-8 sm:-my-px sm:flex">
                            <x-nav-link :href="route('orders.index')" :active="request()->routeIs('orders.index')">
                                {{ __('Заказы') }}
                            </x-nav-link>
                        </div>
                    </div>
                    <span class="ml-4 text-gray-300 content-center">Баланс: {{ number_format(auth()->user()->balance, 2, '.', ' ') }} руб.</span>
                    <!-- Settings Dropdown -->
                    <div class="hidden sm:flex sm:items-center sm:ms-6">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 dark:text-gray-400 bg-white dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                                    <div>{{ Auth::user()->name }}</div>

                                    <div class="ms-1">
                                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                        </svg>
                                    </div>
                                </button>
                            </x-slot>

                            <x-slot name="content">
                                <x-dropdown-link :href="route('profile.edit')">
                                    {{ __('Profile') }}
                                </x-dropdown-link>

                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf

                                    <x-dropdown-link :href="route('logout')"
                                            onclick="event.preventDefault();
                                                        this.closest('form').submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>

                    <!-- Hamburger -->
                    <div class="-me-2 flex items-center sm:hidden">
                        <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                            <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                                <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                                <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>

            <!-- Responsive Navigation Menu -->
            <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
                <div class="pt-2 pb-3 space-y-1">
                    <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        {{ __('Dashboard') }}
                    </x-responsive-nav-link>
                </div>

                <!-- Responsive Settings Options -->
                <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
                    <div class="px-4">
                        <div class="font-medium text-base text-gray-800 dark:text-gray-200">{{ Auth::user()->name }}</div>
                        <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                    </div>

                    <div class="mt-3 space-y-1">
                        <x-responsive-nav-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-responsive-nav-link>

                        <!-- Authentication -->
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf

                            <x-responsive-nav-link :href="route('logout')"
                                    onclick="event.preventDefault();
                                                this.closest('form').submit();">
                                {{ __('Log Out') }}
                            </x-responsive-nav-link>
                        </form>
                    </div>
                </div>
            </div>
        @endauth
    </nav>

<!-- Иконка корзины с количеством товаров -->
@if(!request()->is('cart*') && !request()->is('order*')) <!-- Проверяем, не на странице корзины или заказа -->
    @if(session('cart') && count(session('cart')) > 0)
        <a href="{{ route('cart.view') }}" class="group fixed bottom-20 right-5">
            <!-- Иконка корзины -->


            <!-- Количество товаров -->
            <span class="absolute -top-2 -right-2 inline-flex items-center justify-center w-20 h-20 text-lg font-bold text-white bg-red-500 rounded-full shadow-lg group-hover:scale-110 transform transition duration-300">
                <i class="fa fa-shopping-cart pr-1 text-2xl text-gray-700 group-hover:text-gray-900 transition duration-100"></i>
                {{ count(session('cart')) }}
            </span>


        </a>
    @endif
@endif
