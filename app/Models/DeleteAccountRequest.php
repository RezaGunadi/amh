<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class DeleteAccountRequest extends Model
{
    use HasUuids;
    
    protected $table = 'delete_account_requests';
    
    protected $fillable = [
        'user_id',
        'reason',
        'status',
        'processed_at',
        'processed_by',
    ];
    
    protected $casts = [
        'processed_at' => 'datetime',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function processedBy()
    {
        return $this->belongsTo(Admin::class, 'processed_by');
    }
}
