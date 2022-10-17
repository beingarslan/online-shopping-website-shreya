<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Models\Item;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ItemController extends Controller
{

    public function searchItems($key)
    {
        $items = Item::where('name', 'like', '%' . $key . '%')
            ->orWhere('price', 'like', '%' . $key . '%')
            ->orWhere('id', 'like', '%' . $key . '%')
            ->orWhereHas('seller', function ($query) use ($key) {
                $query->where('ip_address', 'like', '%' . $key . '%');
            })
            ->get();
        return response()->json($items);
    }

    public function sellerItems($seller_id)
    {
        $items = Item::where('seller_id', $seller_id)->get();
        return response()->json($items);
    }

    public function purchaseItems(Request $request)
    {
        $validated = Validator::make($request->all(), [
            'user_id' => 'required|integer|exists:users,id',
            'item_id' => 'required|integer|exists:items,id',
            'quantity' => 'required|integer|min:1',
            'seller_ip' => 'required|integer|exists:sellers,ip_address',
        ]);

        if ($validated->fails()) {
            return response()->json($validated->errors(), 400);
        }

        $item = Item::where('id', $request->item_id)->first();

        if ($item->quantity < $request->quantity) {
            return response()->json(['message' => 'Not enough items in stock'], 400);
        }

        $user = User::where('id', $request->user_id)->first();
        if ($user->balance < $item->price * $request->quantity) {
            return response()->json(['message' => 'Not enough balance'], 400);
        }

        $user->balance -= $item->price * $request->quantity;
        $user->save();

        $item->quantity -= $request->quantity;
        $item->save();

        $purchase = $user->purchases()->create([
            'item_id' => $request->item_id,
            'quantity' => $request->quantity,
            'price' => $item->price * $request->quantity,
        ]);

        return response()->json($purchase);
    }
}
