<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Notifications\CustomVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * User types
     */
    const TYPE_INDIVIDUAL = 'individual';
    const TYPE_PROFESSIONAL = 'professional';

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'type',
        'company_name',
        'siret',
        'phone',
        'is_active'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_active' => 'boolean'
        ];
    }

    /**
     * Check if user is professional
     */
    public function isProfessional(): bool
    {
        return $this->type === self::TYPE_PROFESSIONAL;
    }

    /**
     * Get display name
     */
    public function getDisplayName(): string
    {
        return $this->isProfessional() && $this->company_name 
            ? $this->company_name 
            : $this->name;
    }

    /**
     * Scope for professional users
     */
    public function scopeProfessional($query)
    {
        return $query->where('type', self::TYPE_PROFESSIONAL);
    }

    /**
     * Scope for individual users
     */
    public function scopeIndividual($query)
    {
        return $query->where('type', self::TYPE_INDIVIDUAL);
    }

    /**
     * Send the email verification notification.
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new CustomVerifyEmail);
    }

    /**
     * Get user's cart items
     */
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    /**
     * Get user's orders
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
