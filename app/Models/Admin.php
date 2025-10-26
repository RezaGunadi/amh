<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Admin extends Model
{
    use HasUuids;
    
    protected $table = 'admins';
    
    protected $fillable = [
        'name',
        'email',
        'username',
        'is_super',
    ];
    
    protected $casts = [
        'is_super' => 'boolean',
    ];
    
    public function deleteAccountRequests()
    {
        return $this->hasMany(DeleteAccountRequest::class, 'processed_by');
    }
}
