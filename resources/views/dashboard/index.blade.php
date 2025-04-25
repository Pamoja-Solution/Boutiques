<x-app-layout>
    @section("titre","Gestion des Produits")
    @include('gerant.nav')

    @if (auth()->user()->isGerant() || auth()->user()->isSuperviseur())

    <livewire:dashboard>
        @else
        @endif
</x-app-layout>
