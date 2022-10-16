<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePurchaseRequest;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    // search purchases
    public function searchPurchases($key)
    {
        $purchases = Purchase::where('id', $key)
            ->orWhere('user_id',  $key)
            ->get();
        return response()->json($purchases);
    }

    // cancel purchase
    public function cancelPurchase($purchase_id)
    {
        $purchase = Purchase::where('id', $purchase_id)->first();

        $user = $purchase->user;
        $user->balance += $purchase->price;
        $user->save();

        $item = $purchase->item;
        $item->quantity += $purchase->quantity;
        $item->save();

        $purchase->delete();
        return response()->json(['message' => 'Purchase canceled']);
    }

    // get add balance
    public function addBalance(Request $request)
    {
        $user = $request->user();
        $user->balance += $request->balance;
        $user->save();
        return response()->json(['message' => 'Balance added']);
    }
}
