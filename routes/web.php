<?php

use Illuminate\Support\Facades\Route;
use CNRP\InvoicePackage\Http\Controllers\InvoiceController;

Route::get('invoices/download/{filename}', [InvoiceController::class, 'download'])->name('invoices.download');
