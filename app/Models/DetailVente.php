<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DetailVente extends Model
{
    use HasFactory;

    protected $fillable = ['vente_id', 'medicament_id', 'quantite', 'prix_unitaire'];
    protected $table ='details_vente';

    public function medicament()
    {
        return $this->belongsTo(Medicament::class);
    }

    public function vente()
    {
        return $this->belongsTo(Vente::class);
    }
}
