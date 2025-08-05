
<nav x-data="{ open: false }" class="bg-gray-800 border-b  border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                 
                <!-- Navigation Links -->
                <div class="hidden  sm:-my-px sm:ms-10 sm:flex ">
                    <x-nav-link :href="route('posts.index')" :active="request()->routeIs('posts.*')">
                    {{ __('投稿') }}
                    </x-nav-link>
                </div>
            </div>

            <!-- Settings Dropdown -->
                                  <!-- Settings / Auth Links -->
            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">
                @auth
                    <span class="text-sm text-gray-300">
                        {{ Auth::user()->name }}
                    </span>

             <x-nav-link :href="route('profile.edit')" :active="request()->routeIs('profile.edit')">
                        {{ __('Profile') }}
                    </x-nav-link>
                
                    <form method="POST" action="{{ route('logout') }}" class="inline">
                        @csrf
                        <x-nav-link :href="route('logout')"
                     onclick="event.preventDefault(); if (confirm('ログアウトしますか？')) { this.closest('form').submit(); }">
                            {{ __('Log Out') }}
                        </x-nav-link>
                    </form>
                @else
                    <x-nav-link :href="route('login')" :active="request()->routeIs('login')">
                        {{ __('Log in') }}
                    </x-nav-link>

                    @if (Route::has('register'))
                        <x-nav-link :href="route('register')" :active="request()->routeIs('register')">
                            {{ __('Register') }}
                        </x-nav-link>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</nav>

