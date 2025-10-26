<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Favorite extends Model
{ use SoftDeletes;
    
    protected $table = 'favorites';
    
    protected $fillable = [
        'user_id',
        'food_id',
        'food_name',
        'image_url',
    ];
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
    public function menuMakanan()
    {
        return $this->belongsTo(MenuMakanan::class, 'food_id');
    }
}
