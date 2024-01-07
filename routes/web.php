<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\PaymentController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/order-complete', [PaymentController::class, 'orderComplete']);
Route::get('/qrcode', function () {
  $qr = \QrCode::size(500)->generate('Reuben');
  $exploded = explode(PHP_EOL, $qr);
  return view('test', compact('exploded'));
});
Route::get('/generate-pdf', [PdfController::class, 'generatePdf']);

Route::middleware('visitor')->get('{any}', function () {
  return view('welcome');
})->where('any', '.*');
