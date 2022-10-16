<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'quantity',
        'price',
    ];

    /**
     * Get the user that owns the purchase.
     */

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Get the item that owns the purchase.
     */

    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    /**
     * Get the seller that owns the purchase.
     */
    public function seller()
    {
        return $this->hasOneThrough(Seller::class, Item::class, 'id', 'id', 'item_id', 'seller_id');
    }
}
