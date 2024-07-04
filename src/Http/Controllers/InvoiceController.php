<?php

namespace CNRP\InvoicePackage\Http\Controllers;

use CNRP\InvoicePackage\Invoice;
use Spatie\LaravelPdf\Facades\Pdf;
use Illuminate\Routing\Controller;
use CNRP\InvoicePackage\Theme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InvoiceController extends Controller
{
    // public function __invoke(Request $request)
    // {
    //     try {
    //         Log::info('Starting invoice generation');

    //         // Create theme
    //         $theme = new Theme('invoice::default', [
    //             'header' => ['font-size' => '28px', 'color' => '#1a5f7a'],
    //         ], [
    //             'primary' => '#1a5f7a',
    //         ]);

    //         // Create invoice
    //         $invoice = new Invoice([
    //             'company' => $request->input('company'),
    //             'logo' => $request->input('logo'),
    //         ], $theme);

    //         // Populate the invoice with dynamic items
    //         $items = json_decode($request->input('items'), true);
    //         foreach ($items as $item) {
    //             $invoice->addItem($item['description'], $item['quantity'], $item['price']);
    //         }

    //         Log::info('Invoice data prepared, starting PDF generation');

    //         // Generate and return the PDF
    //         return Pdf::view('invoice::default')
    //         ->format('a4')
    //         ->name('invoice-' . time() . '.pdf')
    //         ->withBrowsershot(function ($browsershot) {
    //             $browsershot->setNodeBinary(config('invoice.node_binary'))->noSandbox();
    //         })
    //         ->download();

    //     } catch (\Exception $e) {
    //         Log::error('PDF generation failed: ' . $e->getMessage());
    //         return response()->json(['error' => 'PDF generation failed: ' . $e->getMessage()], 500);
    //     }
    // }

    public function download($filename)
    {
        $path = storage_path('app/invoices/' . $filename);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->download($path)->deleteFileAfterSend(true);
    }
}
