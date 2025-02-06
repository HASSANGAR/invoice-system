<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;

Route::get('/', function () {
    return view('home');
});

Route::resource('debts', DebtController::class);
Route::resource('products', ProductController::class);
Route::resource('invoices', InvoiceController::class);

Route::get('/invoices/{invoice}/print', [InvoiceController::class, 'print'])->name('invoices.print');
