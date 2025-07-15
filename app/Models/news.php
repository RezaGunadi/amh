<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class news extends Model
{
    use HasFactory;

    protected $table = 'news';
    protected $fillable = [
        'user_id',
        'title', 
        'slug',
        'category', 
        'description', 
        'created_by',
        'is_home',
        'is_deleted',
        'priority'
    ];

    protected $casts = [
        'is_home' => 'boolean',
        'is_deleted' => 'boolean',
        'priority' => 'integer'
    ];

    public function images()
    {
        return $this->hasMany('App\Image', 'news_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    // Accessor untuk description (jika field di database masih 'discription')
    public function getDescriptionAttribute($value)
    {
        return $value;
    }

    public function setDescriptionAttribute($value)
    {
        $this->attributes['description'] = $value;
    }
}
