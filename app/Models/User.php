<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;


    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guarded = [
        'id',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    // protected $hidden = [
    //     'password',
    //     'remember_token',
    // ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'deletion_requested_at' => 'datetime',
        'usage_analytics_consent' => 'boolean',
        'location_data_consent' => 'boolean',
        'marketing_consent' => 'boolean',
        'data_sharing_consent' => 'boolean',
        'privacy_policy_accepted' => 'boolean',
        'terms_accepted' => 'boolean',
        'privacy_policy_accepted_at' => 'datetime',
        'terms_accepted_at' => 'datetime',
        'consent_updated_at' => 'datetime',
    ];

    public function news(){
        return $this->hasMany('App\Models\news', 'created_by');
    }
    
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
    
    public function history()
    {
        return $this->hasMany(History::class);
    }
    
    public function deleteAccountRequests()
    {
        return $this->hasMany(DeleteAccountRequest::class);
    }
}
