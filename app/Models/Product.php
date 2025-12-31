<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'description',
        'short_description',
        'wood_type',
        'usage_type',
        'humidity_rate',
        'conditioning',
        'unit_type',
        'price_per_unit',
        'professional_price',
        'stock_quantity',
        'min_order_quantity',
        'alert_stock_level',
        'is_professional_only',
        'category_id',
        'seo_title',
        'meta_description',
        'status'
    ];

    protected $casts = [
        'price_per_unit' => 'decimal:2',
        'professional_price' => 'decimal:2',
        'humidity_rate' => 'decimal:1',
        'is_professional_only' => 'boolean'
    ];

    /**
     * Constants for enum values
     */
    const WOOD_TYPES = [
        'chene' => 'Chêne',
        'hetre' => 'Hêtre', 
        'charme' => 'Charme',
        'fruitiers' => 'Bois fruitiers',
        'sapin' => 'Sapin',
        'epicea' => 'Épicéa',
        'bouleau' => 'Bouleau',
        'melange' => 'Mélange',
        'fresne' => 'Frêne',
        'acacia' => 'Acacia',
        'chataignier' => 'Châtaignier',
        'pommier' => 'Pommier',
        'cerisier' => 'Cerisier'
    ];

    const USAGE_TYPES = [
        'chauffage' => 'Chauffage',
        'cuisson' => 'Cuisson',
        'both' => 'Chauffage et cuisson'
    ];

    const CONDITIONING_TYPES = [
        'vrac' => 'En vrac',
        'sacs_25kg' => 'Sacs de 25kg',
        'sacs_40kg' => 'Sacs de 40kg',
        'palettes' => 'Palettes',
        'steres' => 'Stères',
        'big_bags' => 'Big bags'
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($product) {
            if (!$product->slug) {
                $product->slug = \Str::slug($product->name);
            }
        });
    }

    /**
     * Get the route key for the model.
     */
    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    /**
     * Category relationship
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Product images
     */
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('sort_order');
    }

    /**
     * Primary image
     */
    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', true);
    }

    /**
     * Scope for active products
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope for in stock products
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /**
     * Scope for filtering by wood type
     */
    public function scopeByWoodType($query, $woodType)
    {
        return $query->where('wood_type', $woodType);
    }

    /**
     * Scope for filtering by usage
     */
    public function scopeByUsage($query, $usage)
    {
        return $query->where('usage_type', $usage);
    }

    /**
     * Get price for user type
     */
    public function getPriceForUser($isProfessional = false)
    {
        return $isProfessional && $this->professional_price 
            ? $this->professional_price 
            : $this->price_per_unit;
    }

    /**
     * Check if product is in stock
     */
    public function isInStock(): bool
    {
        return $this->stock_quantity > 0;
    }

    /**
     * Check if stock is low
     */
    public function isLowStock(): bool
    {
        return $this->stock_quantity <= $this->alert_stock_level;
    }

    /**
     * Get formatted wood type
     */
    public function getWoodTypeLabel(): string
    {
        return self::WOOD_TYPES[$this->wood_type] ?? $this->wood_type;
    }

    /**
     * Get formatted usage type
     */
    public function getUsageTypeLabel(): string
    {
        return self::USAGE_TYPES[$this->usage_type] ?? $this->usage_type;
    }
}