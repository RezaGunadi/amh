<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class PasswordReset extends Model
{
    protected $table = 'password_resets';
    
    public $timestamps = true;
    
    protected $fillable = [
        'email',
        'token',
        'expires_at',
        'used'
    ];
    
    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
    
    /**
     * Check if token is expired
     */
    public function isExpired()
    {
        if (!$this->expires_at) {
            return true; // If no expiry date, consider expired for safety
        }
        return $this->expires_at < now();
    }
    
    /**
     * Check if token is valid (not used and not expired)
     */
    public function isValid()
    {
        if ($this->used) {
            return false;
        }
        return !$this->isExpired();
    }
    
    /**
     * Mark token as used
     */
    public function markAsUsed()
    {
        $this->update(['used' => true]);
    }
    
    /**
     * Generate a new reset token
     */
    public static function generateToken()
    {
        return bin2hex(random_bytes(32));
    }
    
    /**
     * Create a new password reset record
     */
    public static function createReset($email)
    {
        // Delete any existing tokens for this email
        self::where('email', $email)->delete();
        
        // Generate token
        $token = self::generateToken();
        
        // Log token untuk debugging
        Log::info('Creating password reset token for: ' . $email);
        Log::info('Generated token: ' . $token);
        Log::info('Token length: ' . strlen($token));
        
        // Create new token
        $passwordReset = self::create([
            'email' => strtolower($email),
            'token' => $token,
            'expires_at' => now()->addHours(1), // Token expires in 1 hour
            'used' => false
        ]);
        
        // Verify token was saved correctly
        $savedToken = self::where('email', strtolower($email))->latest()->first();
        if ($savedToken) {
            Log::info('Token saved in DB: ' . $savedToken->token);
            Log::info('Tokens match: ' . ($savedToken->token === $token ? 'true' : 'false'));
        }
        
        return $passwordReset;
    }
}
