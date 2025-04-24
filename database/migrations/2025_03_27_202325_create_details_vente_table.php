<?php

use App\Models\Medicament;
use App\Models\Produit;
use App\Models\Vente;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('details_vente', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Vente::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(Produit::class)->constrained()->cascadeOnDelete();

            $table->unsignedInteger('quantite');
            $table->decimal('prix_unitaire');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('details_vente');
    }
};
