<x-app-layout>
    @section("titre","Gestion des Produits")

    @if (auth()->user()->isGerant() || auth()->user()->isSuperviseur())
    @include('gerant.nav')

    <livewire:dashboard>
        @else
        @endif
</x-app-layout>
