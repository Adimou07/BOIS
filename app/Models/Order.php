<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'subtotal',
        'delivery_cost',
        'tax_amount',
        'total',
        'shipping_name',
        'shipping_address',
        'shipping_city',
        'shipping_postal_code',
        'shipping_country',
        'billing_name',
        'billing_address',
        'billing_city',
        'billing_postal_code',
        'billing_country',
        'company_name',
        'siret',
        'payment_method',
        'payment_type',
        'deposit_amount',
        'remaining_amount',
        'deposit_status',
        'remaining_status',
        'payment_status',
        'payment_reference',
        'notes',
        'shipped_at',
        'delivered_at',
        'deposit_paid_at',
        'remaining_paid_at',
    ];

    protected $casts = [
        'subtotal' => 'decimal:2',
        'delivery_cost' => 'decimal:2',
        'tax_amount' => 'decimal:2',
        'total' => 'decimal:2',
        'deposit_amount' => 'decimal:2',
        'remaining_amount' => 'decimal:2',
        'shipped_at' => 'datetime',
        'delivered_at' => 'datetime',
        'deposit_paid_at' => 'datetime',
        'remaining_paid_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Generate a unique order number
     */
    public static function generateOrderNumber(): string
    {
        do {
            $orderNumber = 'WS-' . date('Y') . '-' . strtoupper(Str::random(6));
        } while (self::where('order_number', $orderNumber)->exists());

        return $orderNumber;
    }

    /**
     * Get the status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'bg-yellow-100 text-yellow-800',
            'confirmed' => 'bg-blue-100 text-blue-800',
            'processing' => 'bg-indigo-100 text-indigo-800',
            'shipped' => 'bg-purple-100 text-purple-800',
            'delivered' => 'bg-green-100 text-green-800',
            'cancelled' => 'bg-red-100 text-red-800',
            default => 'bg-gray-100 text-gray-800',
        };
    }

    /**
     * Get the status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'pending' => 'En attente',
            'confirmed' => 'Confirmée',
            'processing' => 'En préparation',
            'shipped' => 'Expédiée',
            'delivered' => 'Livrée',
            'cancelled' => 'Annulée',
            default => 'Inconnu',
        };
    }

    /**
     * Check if the order can be cancelled
     */
    public function canBeCancelled(): bool
    {
        return in_array($this->status, ['pending', 'confirmed']);
    }

    /**
     * Check if order uses partial payment
     */
    public function isPartialPayment(): bool
    {
        return $this->payment_type === 'partial';
    }

    /**
     * Check if deposit is paid
     */
    public function isDepositPaid(): bool
    {
        return $this->deposit_status === 'paid';
    }

    /**
     * Check if remaining amount is paid
     */
    public function isRemainingPaid(): bool
    {
        return $this->remaining_status === 'paid';
    }

    /**
     * Check if order is fully paid
     */
    public function isFullyPaid(): bool
    {
        if ($this->payment_type === 'full') {
            return $this->payment_status === 'paid';
        }
        
        return $this->isDepositPaid() && $this->isRemainingPaid();
    }

    /**
     * Get payment status label
     */
    public function getPaymentStatusLabel(): string
    {
        if ($this->payment_type === 'full') {
            return match($this->payment_status) {
                'paid' => 'Payé',
                'pending' => 'En attente',
                'failed' => 'Échec',
                default => 'Inconnu'
            };
        }

        if ($this->isFullyPaid()) {
            return 'Entièrement payé';
        }

        if ($this->isDepositPaid()) {
            return "Acompte payé ({$this->deposit_amount}€) - Solde à la livraison ({$this->remaining_amount}€)";
        }

        return "Acompte en attente ({$this->deposit_amount}€)";
    }

    /**
     * Calculate deposit and remaining amounts
     */
    public function calculatePaymentSplit(float $depositPercentage = 50): void
    {
        $this->deposit_amount = round($this->total * ($depositPercentage / 100), 2);
        $this->remaining_amount = round($this->total - $this->deposit_amount, 2);
    }
}
