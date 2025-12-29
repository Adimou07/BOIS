<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Category extends Model
{

    protected $fillable = [
        'name',
        'slug',
        'description',
        'parent_id',
        'image_url',
        'sort_order',
        'is_active',
        'seo_title',
        'meta_description'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    /**
     * Boot method to auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($category) {
            if (!$category->slug) {
                $category->slug = \Str::slug($category->name);
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
     * Products belonging to this category
     */
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    /**
     * Parent category
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    /**
     * Child categories
     */
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Get active categories only
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Order by sort order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order');
    }
}