<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Barryvdh\DomPDF\Facade\PDF;

class InvoiceController extends Controller
{
    public function generatePDF($saleId)
    {
        $vente = Vente::with('client', 'detailsVentes.medicament')->findOrFail($saleId);

        $pdf = PDF::loadView('pdf.invoice', compact('vente'));

        return $pdf->stream('facture-' . $saleId . '.pdf'); // Afficher dans le navigateur
        // return $pdf->download('facture-' . $saleId . '.pdf'); // Télécharger directement
    }
    // Dans VenteController.php ou autre contrôleur approprié
    public function printInvoice(Vente $vente)
    {
        $vente->load(['client', 'details.medicament']);
        
        $pdf = Pdf::loadView('pdf.invoice', compact('vente'))
                ->setPaper([0, 0, 226.77, 425.19]); // 80mm x 150mm
        
        return $pdf->download("facture_{$vente->id}.pdf");
    }
}
