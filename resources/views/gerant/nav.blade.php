<nav x-data="{ open: false }" class="bg-white border-b border-gray-100 dark:border-gray-500 dark:bg-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 ">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                

                <!-- Navigation Links -->
                <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex ">
                
                    
                    @if (auth()->user()->isGerant() || auth()->user()->isSuperviseur())
                    <x-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                        {{ __('Utilisateurs') }}
                    </x-nav-link>
                    
                    <x-nav-link href="{{ route('produits.index') }}" :active="request()->routeIs('produits.index')">
                        {{ __('Produits') }}
                    </x-nav-link>
                    
                    <x-nav-link href="{{ route('fournisseurs.index') }}" :active="request()->routeIs('fournisseurs.index')">
                        {{ __('Fournisseurs') }}
                    </x-nav-link>
                    
                    @endif
                    
                    <x-nav-link href="{{ route('clients.index') }}" :active="request()->routeIs('clients.index')">
                        {{ __('Clients') }}
                    </x-nav-link>
                    
                    
                    @if (auth()->user()->isGerant() || auth()->user()->isSuperviseur())
                    <x-nav-link href="{{ route('achats.index') }}" :active="request()->routeIs('achats.index')">
                        {{ __('Achats') }}
                    </x-nav-link>
                    <x-nav-link href="{{ route('ventes.index') }}" :active="request()->routeIs('ventes.index')">
                        {{ __('Ventes') }}
                    </x-nav-link>
                    

                    <x-nav-link href="{{ route('rayons.index') }}" :active="request()->routeIs('rayons.index')">
                        {{ __('Rayons') }}
                    </x-nav-link>
                    @endif
                </div>
            </div>

           

            <!-- Hamburger -->
            <div class="-mr-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">
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

            <x-responsive-nav-link href="{{ route('dashboard') }}" :active="request()->routeIs('dashboard')">
                {{ __('Tableau de bord') }}
            </x-responsive-nav-link>
            @if (auth()->user()->isGerant() || auth()->user()->isSuperviseur())
            
            <x-responsive-nav-link href="{{ route('users.index') }}" :active="request()->routeIs('users.index')">
                {{ __('Utilisateurs') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link href="{{ route('produits.index') }}" :active="request()->routeIs('produits.index')">
                {{ __('Produits') }}
            </x-responsive-nav-link>
            
            <x-responsive-nav-link href="{{ route('fournisseurs.index') }}" :active="request()->routeIs('fournisseurs.index')">
                {{ __('Fournisseurs') }}
            </x-responsive-nav-link>
            @endif
            
            <x-responsive-nav-link href="{{ route('clients.index') }}" :active="request()->routeIs('clients.index')">
                {{ __('Clients') }}
            </x-responsive-nav-link>
            @if (auth()->user()->isGerant() || auth()->user()->isSuperviseur())
            
            <x-responsive-nav-link href="{{ route('ventes.index') }}" :active="request()->routeIs('ventes.index')">
                {{ __('Ventes') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('achats.index') }}" :active="request()->routeIs('achats.index')">
                {{ __('Rayons') }}
            </x-responsive-nav-link>
            <x-responsive-nav-link href="{{ route('achats.index') }}" :active="request()->routeIs('achats.index')">
                {{ __('Achats') }}
            </x-responsive-nav-link>

            
            @endif
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="flex items-center px-4">
                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                    <div class="shrink-0 mr-3">
                        <img class="h-10 w-10 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                    </div>
                @endif

                <div>
                    <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                    <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
                </div>
            </div>

            <div class="mt-3 space-y-1">
                <!-- Account Management -->
                <x-responsive-nav-link href="{{ route('profile.show') }}" :active="request()->routeIs('profile.show')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>

                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                    <x-responsive-nav-link href="{{ route('api-tokens.index') }}" :active="request()->routeIs('api-tokens.index')">
                        {{ __('API Tokens') }}
                    </x-responsive-nav-link>
                @endif

                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}" x-data>
                    @csrf

                    <x-responsive-nav-link href="{{ route('logout') }}"
                                @click.prevent="$root.submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>

                <!-- Team Management -->
                @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                    <div class="border-t border-gray-200"></div>

                    <div class="block px-4 py-2 text-xs text-gray-400">
                        {{ __('Manage Team') }}
                    </div>

                    <!-- Team Settings -->
                    <x-responsive-nav-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}" :active="request()->routeIs('teams.show')">
                        {{ __('Team Settings') }}
                    </x-responsive-nav-link>

                    @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                        <x-responsive-nav-link href="{{ route('teams.create') }}" :active="request()->routeIs('teams.create')">
                            {{ __('Create New Team') }}
                        </x-responsive-nav-link>
                    @endcan

                    <!-- Team Switcher -->
                    @if (Auth::user()->allTeams()->count() > 1)
                        <div class="border-t border-gray-200"></div>

                        <div class="block px-4 py-2 text-xs text-gray-400">
                            {{ __('Switch Teams') }}
                        </div>

                        @foreach (Auth::user()->allTeams() as $team)
                            <x-switchable-team :team="$team" component="responsive-nav-link" />
                        @endforeach
                    @endif
                @endif
            </div>
        </div>
    </div>
</nav>