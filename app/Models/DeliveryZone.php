<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryZone extends Model
{
    protected $fillable = [
        'name',
        'postal_codes',
        'delivery_cost',
        'free_delivery_threshold',
        'min_delivery_days',
        'max_delivery_days',
        'is_active',
        'sort_order'
    ];

    protected $casts = [
        'postal_codes' => 'array',
        'delivery_cost' => 'decimal:2',
        'free_delivery_threshold' => 'decimal:2',
        'is_active' => 'boolean'
    ];

    /**
     * Scope for active zones
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope ordered by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }

    /**
     * Find delivery zone by postal code
     */
    public static function findByPostalCode(string $postalCode): ?self
    {
        return self::active()
            ->get()
            ->first(function ($zone) use ($postalCode) {
                return in_array($postalCode, $zone->postal_codes);
            });
    }

    /**
     * Calculate delivery cost for order amount
     */
    public function calculateDeliveryCost(float $orderAmount): float
    {
        if ($this->free_delivery_threshold && $orderAmount >= $this->free_delivery_threshold) {
            return 0.00;
        }
        
        return $this->delivery_cost;
    }

    /**
     * Check if delivery is free for given amount
     */
    public function isFreeDelivery(float $orderAmount): bool
    {
        return $this->calculateDeliveryCost($orderAmount) == 0;
    }

    /**
     * Get delivery time estimate
     */
    public function getDeliveryTimeEstimate(): string
    {
        if ($this->min_delivery_days === $this->max_delivery_days) {
            return $this->min_delivery_days === 1 
                ? "Livraison sous 24h"
                : "Livraison sous {$this->min_delivery_days} jours";
        }
        
        return "Livraison sous {$this->min_delivery_days} à {$this->max_delivery_days} jours";
    }

    /**
     * Get amount needed for free delivery
     */
    public function getAmountForFreeDelivery(float $currentAmount): ?float
    {
        if (!$this->free_delivery_threshold) {
            return null;
        }
        
        if ($currentAmount >= $this->free_delivery_threshold) {
            return null;
        }
        
        return $this->free_delivery_threshold - $currentAmount;
    }
}