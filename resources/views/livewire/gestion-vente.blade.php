<!-- resources/views/livewire/gestion-vente.blade.php -->
<div class="py-6 bg-gray-100 min-h-screen">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- En-tête -->
        <div class="bg-white shadow-sm rounded-lg p-6 mb-6">
            <h2 class="text-2xl font-semibold text-gray-800 mb-2">Gestion des ventes</h2>
            
            <a href="{{ route('vendeur.stat') }}" type="button" class="text-gray-900 bg-white hover:bg-gray-100 border border-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-600 dark:bg-gray-800 dark:border-gray-700 dark:text-white dark:hover:bg-gray-700 me-2 mb-2">
                <svg class="w-6 h-6 me-2 -ms-1 text-gray-800 dark:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15v4m6-6v6m6-4v4m6-6v6M3 11l6-5 6 5 5.5-5.5"/>
                </svg>
                Statistiques
            </a>
            
            <!-- Dashboard metrics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
                <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                    <h3 class="font-semibold text-blue-800">Ventes aujourd'hui</h3>
                    <p class="text-2xl font-bold text-blue-600">{{ count($this->getRecentVentes()) }}</p>
                </div>
                
                <div class="bg-yellow-50 rounded-lg p-4 border border-yellow-100">
                    <h3 class="font-semibold text-yellow-800">Produits en promotion</h3>
                    <p class="text-2xl font-bold text-yellow-600">0</p>
                </div>
                
                <div class="bg-red-50 rounded-lg p-4 border border-red-100">
                    <h3 class="font-semibold text-red-800">Stock faible</h3>
                    <p class="text-2xl font-bold text-red-600">{{ count($this->getProduitsLowStock()) }}</p>
                </div>
            </div>
        </div>
        
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Liste des produits -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Produits disponibles</h3>
                    
                    <p class="text-gray-600">Recherchez des produits par nom, code-barre ou référence</p>
                    
                    <div class="mt-4">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input 
                                wire:model.live="search" 
                                type="text" 
                                class="pl-10 w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                placeholder="Rechercher un produit...">
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Emplacement</th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @forelse($produits as $produit)
                                    <tr>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $produit->nom }}</div>
                                            <div class="text-xs text-gray-500">{{ $produit->reference_interne }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ number_format($produit->prix_vente, 2) }} Fc</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">{{ $produit->stock }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm text-gray-900">
                                                @if($produit->sousRayon)
                                                    {{ $produit->sousRayon->rayon->nom }} / {{ $produit->sousRayon->nom }}
                                                @else
                                                    Non classé
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                            <button 
                                                wire:click="openModal('details', {{ $produit->id }})"
                                                class="text-blue-600 hover:text-blue-900 mr-2">
                                                Détails
                                            </button>
                                            <button 
                                                wire:click="addToCart({{ $produit->id }})"
                                                class="text-green-600 hover:text-green-900">
                                                + Panier
                                            </button>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            Aucun produit trouvé
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="mt-4">
                        {{ $produits->links() }}
                    </div>
                </div>
            </div>
            
            <!-- Panier -->
            <div class="lg:col-span-1">
                <div class="bg-white shadow-sm rounded-lg p-6">
                    <h3 class="text-xl font-semibold text-gray-800 mb-4">Panier</h3>
                    
                    @if(count($this->selectedProduits) > 0)
                        <div class="mb-4">
                            <div class="flex justify-between items-center mb-1">
                                <label for="clientSearch" class="block text-sm font-medium text-gray-700">Client</label>
                                <button 
                                    wire:click="openNewClientModal" 
                                    class="text-sm text-indigo-600 hover:text-indigo-900"
                                >
                                    + Nouveau client
                                </button>
                            </div>
                            
                            <div class="relative">
                                <input 
                                    type="text" 
                                    id="clientSearch" 
                                    wire:model.live="clientSearch"
                                    placeholder="Rechercher un client..."
                                    class="w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                >
                                
                                @if($clientId)
                                    <div class="mt-2 p-2 bg-blue-50 rounded-md">
                                        <div class="flex justify-between items-center">
                                            <div>
                                                <p class="font-medium">{{ $selectedClient->nom ?? '' }}</p>
                                                <p class="text-sm text-gray-600">{{ $selectedClient->telephone ?? '' }}</p>
                                            </div>
                                            <button 
                                                wire:click="$set('clientId', null)" 
                                                class="text-gray-400 hover:text-gray-600"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                    </div>
                                @elseif($clientSearch && count($filteredClients) > 0)
                                    <div class="absolute z-10 w-full mt-1 bg-white shadow-lg rounded-md border border-gray-200 max-h-60 overflow-y-auto">
                                        <ul>
                                            @foreach($filteredClients as $client)
                                                <li>
                                                    <button
                                                        wire:click="selectClient({{ $client->id }})"
                                                        class="w-full px-4 py-2 text-left hover:bg-gray-100 focus:outline-none focus:bg-gray-100 text-sm"
                                                    >
                                                        <div class="font-medium">{{ $client->nom }}</div>
                                                        <div class="text-xs text-gray-500">{{ $client->telephone }}</div>
                                                    </button>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            </div>
                        </div>
                        
                        <!-- Liste des produits dans le panier -->
                        <div class="mt-6">
                            <h4 class="font-medium text-gray-700 mb-2">Articles ({{ count($this->selectedProduits) }})</h4>
                            <div class="space-y-3">
                                @foreach($panier as $produit)
                                    <div class="flex flex-col p-3 border border-gray-200 rounded-md">
                                        <div class="flex justify-between items-start mb-2">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $produit->nom }}</p>
                                                <p class="text-sm text-gray-600">{{ number_format($produit->prix_vente, 2) }} Fc/unité</p>
                                            </div>
                                            <button 
                                                wire:click="removeFromCart({{ $produit->id }})"
                                                class="text-red-500 hover:text-red-700"
                                            >
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                                                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                                </svg>
                                            </button>
                                        </div>
                                        
                                        <div class="flex justify-between items-center mt-1">
                                            <div class="flex items-center">
                                                <span class="text-gray-500 text-sm mr-2">Quantité:</span>
                                                <div class="flex items-center border border-gray-300 rounded-md">
                                                    <button 
                                                        wire:click="decrementQuantity({{ $produit->id }})"
                                                        type="button"
                                                        class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-l-md focus:outline-none"
                                                    >
                                                        -
                                                    </button>
                                                    <input 
                                                        type="text" 
                                                        inputmode="numeric"
                                                        wire:model.lazy="quantities.{{ $produit->id }}" 
                                                        wire:change="updateQuantity({{ $produit->id }}, $event.target.value)"
                                                        class="w-12 border-0 text-center focus:ring-0"
                                                    >
                                                    <button 
                                                        wire:click="incrementQuantity({{ $produit->id }})"
                                                        type="button"
                                                        class="px-2 py-1 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-r-md focus:outline-none"
                                                    >
                                                        +
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="font-medium">
                                                {{ number_format($produit->prix_vente * ($quantities[$produit->id] ?? 1), 2) }} Fc
                                            </div>
                                        </div>
                                        
                                        @error('quantities.'.$produit->id) 
                                            <span class="text-red-500 text-xs mt-1">{{ $message }}</span> 
                                        @enderror
                                        
                                        @if(isset($quantities[$produit->id]) && $quantities[$produit->id] > 0)
                                            <div class="text-xs text-gray-500 mt-1">
                                                Stock disponible: {{ $produit->stock }} unités
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <div class="mt-6 border-t pt-4">
                            <div class="flex justify-between font-semibold text-lg text-gray-900">
                                <span>Total:</span>
                                <span>{{ number_format($total, 2) }} Fc</span>
                            </div>
                            
                            <button 
                                wire:click="confirmSale"
                                wire:loading.attr="disabled"
                                class="mt-4 w-full inline-flex justify-center items-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:opacity-50"
                            >
                                <span wire:loading.remove wire:target="confirmSale">Finaliser la vente</span>
                                <span wire:loading wire:target="confirmSale" class="flex items-center">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    Traitement...
                                </span>
                            </button>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                            <p class="mt-2">Votre panier est vide</p>
                            <p class="text-sm mt-1">Ajoutez des produits depuis la liste</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    
    <!-- Modal Détails Produit -->
    @if($showModal && $modalType === 'details' && $selectedProduit)
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    {{ $selectedProduit->nom }}
                                </h3>
                                <div class="mt-4 space-y-3">
                                    <div>
                                        <h4 class="text-sm font-medium text-gray-500">Description</h4>
                                        <p class="mt-1">{{ $selectedProduit->description ?? 'Aucune description' }}</p>
                                    </div>
                                    
                                    <div class="grid grid-cols-2 gap-4">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Prix de vente</h4>
                                            <p class="mt-1">{{ number_format($selectedProduit->prix_vente, 2) }} Fc</p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Stock</h4>
                                            <p class="mt-1">{{ $selectedProduit->stock }} unités</p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Référence</h4>
                                            <p class="mt-1">{{ $selectedProduit->reference_interne }}</p>
                                        </div>
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-500">Emplacement</h4>
                                            <p class="mt-1">
                                                @if($selectedProduit->sousRayon)
                                                    {{ $selectedProduit->sousRayon->rayon->nom }} / {{ $selectedProduit->sousRayon->nom }}
                                                @else
                                                    Non classé
                                                @endif
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button 
                            wire:click="addToCart({{ $selectedProduit->id }})"
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-indigo-600 text-base font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:ml-3 sm:w-auto sm:text-sm">
                            Ajouter au panier
                        </button>
                        <button 
                            wire:click="closeModal"
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm">
                            Fermer
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Modal Nouveau Client -->
    @if($showModal && $modalType === 'new-client')
        <div class="fixed z-10 inset-0 overflow-y-auto">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"></div>
                
                <div class="inline-block align-bottom bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-blue-100 sm:mx-0 sm:h-10 sm:w-10">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
                                </svg>
                            </div>
                            <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-medium text-gray-900">
                                    Nouveau client
                                </h3>
                                <div class="mt-4 space-y-4">
                                    <div>
                                        <label for="nom" class="block text-sm font-medium text-gray-700">Nom complet</label>
                                        <input 
                                            type="text" 
                                            id="nom" 
                                            wire:model.defer="newClient.nom"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        >
                                        @error('newClient.nom') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="telephone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                        <input 
                                            type="text" 
                                            id="telephone" 
                                            wire:model.defer="newClient.telephone"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        >
                                        @error('newClient.telephone') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                    
                                    <div>
                                        <label for="email" class="block text-sm font-medium text-gray-700">Email (optionnel)</label>
                                        <input 
                                            type="email" 
                                            id="email" 
                                            wire:model.defer="newClient.email"
                                            class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                        >
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                        <button 
                            wire:click="createClient"
                            wire:loading.attr="disabled"
                            type="button" 
                            class="w-full inline-flex justify-center rounded-md border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm disabled:opacity-50"
                        >
                            <span wire:loading.remove wire:target="createClient">Enregistrer</span>
                            <span wire:loading wire:target="createClient" class="flex items-center">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                Enregistrement...
                            </span>
                        </button>
                        <button 
                            wire:click="closeModal"
                            type="button" 
                            class="mt-3 w-full inline-flex justify-center rounded-md border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm"
                        >
                            Annuler
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
    
    <!-- Notifications -->
    @if(session()->has('message'))
        <div 
            x-data="{ show: true }"
            x-init="setTimeout(() => show = false, 3000)"
            x-show="show"
            class="fixed bottom-4 right-4 bg-green-500 text-white px-4 py-2 rounded-md shadow-lg">
            {{ session('message') }}
        </div>
    @endif
    
    <script>
        document.addEventListener('livewire:init', () => {
            Livewire.on('openNewTab', ({ url }) => {
                window.open(url, '_blank');
            });
        });
    </script>
</div>