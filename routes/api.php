<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
// item list web service
Route::get('/{seller_id}/items', [ItemController::class, 'sellerItems'])->name('seller_items');

// search for online items
Route::get('/search/items/{key}', [ItemController::class, 'searchItems']);

// purchase an online item
Route::post('/purchase/items', [ItemController::class, 'purchaseItems']);

// search purchase
Route::get('/search/purchases/{key}', [PurchaseController::class, 'searchPurchases']);

// cancel purchase
Route::delete('/cancel/purchase/{purchase_id}', [PurchaseController::class, 'cancelPurchase']);

// add balance
Route::post('/add/balance', [PurchaseController::class, 'addBalance']);

// card check
Route::post('/card/check', [CardController::class, 'checkCard']);