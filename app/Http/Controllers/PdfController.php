<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Car;

class PdfController extends Controller
{
    public function generatePdf($id)
    {
        // Haal de auto-gegevens op
        $car = Car::with('tags')->findOrFail($id);

        // Genereer de PDF
        $pdf = Pdf::loadView('pdf.car', compact('car'));

        // Download de PDF
        return $pdf->download('car_details.pdf');
    }
}