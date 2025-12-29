<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class EmailVerificationCode extends Model
{
    protected $fillable = [
        'user_id',
        'code',
        'expires_at',
        'is_used'
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean'
    ];

    /**
     * User relationship
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Generate a random 6-digit code
     */
    public static function generateCode(): string
    {
        return str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
    }

    /**
     * Create a new verification code for user
     */
    public static function createForUser(User $user): self
    {
        // Invalider les anciens codes
        self::where('user_id', $user->id)
            ->where('is_used', false)
            ->update(['is_used' => true]);

        // Créer un nouveau code
        return self::create([
            'user_id' => $user->id,
            'code' => self::generateCode(),
            'expires_at' => Carbon::now()->addMinutes(15), // Expire dans 15 minutes
            'is_used' => false
        ]);
    }

    /**
     * Verify a code for a user
     */
    public static function verifyCode(User $user, string $code): bool
    {
        $verificationCode = self::where('user_id', $user->id)
            ->where('code', $code)
            ->where('is_used', false)
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if ($verificationCode) {
            $verificationCode->update(['is_used' => true]);
            return true;
        }

        return false;
    }

    /**
     * Check if code is expired
     */
    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Check if code is valid (not used and not expired)
     */
    public function isValid(): bool
    {
        return !$this->is_used && !$this->isExpired();
    }
}