<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $fillable = [
        'session_id',
        'user_id',
        'product_id',
        'quantity',
        'unit_price'
    ];

    protected $casts = [
        'unit_price' => 'decimal:2'
    ];

    /**
     * Product relationship
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * User relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get total price for this cart item
     */
    public function getTotalPrice(): float
    {
        return $this->quantity * $this->unit_price;
    }

    /**
     * Scope for current session/user cart
     */
    public function scopeForCart($query, $sessionId = null, $userId = null)
    {
        if ($userId) {
            return $query->where('user_id', $userId);
        }
        
        return $query->where('session_id', $sessionId);
    }
}