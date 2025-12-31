<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'read_at'
    ];

    protected $casts = [
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Scopes
     */
    public function scopeNouveau($query)
    {
        return $query->where('status', 'nouveau');
    }

    public function scopeNonLu($query)
    {
        return $query->whereNull('read_at');
    }

    /**
     * Mutators
     */
    public function markAsRead()
    {
        $this->update(['read_at' => now()]);
    }

    /**
     * Accessors
     */
    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            'nouveau' => 'Nouveau',
            'en_cours' => 'En cours',
            'resolu' => 'Résolu',
            'ferme' => 'Fermé',
            default => 'Inconnu'
        };
    }
}
