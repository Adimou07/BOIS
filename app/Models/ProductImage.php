<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'image_url',
        'alt_text',
        'sort_order',
        'is_primary'
    ];

    protected $casts = [
        'is_primary' => 'boolean'
    ];

    /**
     * Product relationship
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the full URL for the image
     */
    public function getFullImageUrlAttribute(): string
    {
        $imageUrl = $this->image_url;
        
        // S'assurer que l'URL commence par /
        if (!str_starts_with($imageUrl, '/')) {
            $imageUrl = '/' . $imageUrl;
        }
        
        return $imageUrl;
    }
}