<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCardRequest;
use App\Http\Requests\UpdateCardRequest;
use App\Models\Card;
use Illuminate\Http\Request;

class CardController extends Controller
{
    // card check
    public function checkCard(Request $request)
    {
        $card = Card::where('number', $request->number)->where('pin', $request->pin)->first();
        if ($card) {
            return response()->json(['message' => 'Card is valid']);
        } else {
            return response()->json(['message' => 'Card is invalid'], 400);
        }
    }
}
