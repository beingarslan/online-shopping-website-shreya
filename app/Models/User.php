<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'address',
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Get the purchases for the user.
     */

    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'user_id', 'id');
    }

    /**
     * Get the sellers for the user.
     */

    public function sellers()
    {
        return $this->hasMany(Seller::class, 'user_id', 'id');
    }

    /**
     * Get the items for the user.
     */

    public function items()
    {
        return $this->hasManyThrough(Item::class, Seller::class, 'user_id', 'seller_id', 'id', 'id');
    }
}
