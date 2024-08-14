<?php

namespace App\Http\Controllers;

use Mpdf\Mpdf;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PdfController extends Controller
{
    public function generatePdf(Request $request)
    {
        $data = $request->all();

        // Create an instance of MPDF
        $mpdf = new Mpdf([
            'default_font' => 'dejavusans',  // Use a font that supports Hebrew
            'mode' => 'utf-8', // Set the document encoding to UTF-8
            'format' => 'A4',
            'directionality' => 'rtl'  // Set the direction to RTL
        ]);

        // Load HTML content with inline CSS for RTL support
        $html = view('pdf_template', compact('data'))->render();

        // Write the HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Output the PDF for download
        return response($mpdf->Output('document.pdf', 'I'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="document.pdf"');
    }

    public function generateAccountDetailsPdf(Request $request)
    {
        $data = $request->all();

        // Create an instance of MPDF
        $mpdf = new Mpdf([
            'default_font' => 'dejavusans',  // Use a font that supports Hebrew
            'mode' => 'utf-8', // Set the document encoding to UTF-8
            'format' => 'A4',
            'directionality' => 'rtl'  // Set the direction to RTL
        ]);

        // Load HTML content with inline CSS for RTL support
        $html = view('account_details_pdf_template', compact('data'))->render();

        // Write the HTML content to the PDF
        $mpdf->WriteHTML($html);

        // Output the PDF for download
        return response($mpdf->Output('account_details.pdf', 'I'), 200)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="account_details.pdf"');
    }
}
