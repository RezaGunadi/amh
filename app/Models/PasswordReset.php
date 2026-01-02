<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
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
        return $this->expires_at < now();
    }
    
    /**
     * Check if token is valid (not used and not expired)
     */
    public function isValid()
    {
        return !$this->used && !$this->isExpired();
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
        
        // Create new token
        return self::create([
            'email' => $email,
            'token' => self::generateToken(),
            'expires_at' => now()->addHours(1), // Token expires in 1 hour
            'used' => false
        ]);
    }
}
