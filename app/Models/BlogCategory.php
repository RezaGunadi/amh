<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'svg_icon',
        'color',
        'post_count',
        'is_active'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'post_count' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($category) {
            if (empty($category->slug)) {
                $category->slug = Str::slug($category->name);
            }
        });
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function posts()
    {
        return $this->hasMany(BlogPost::class, 'category', 'slug');
    }

    public function updatePostCount()
    {
        $this->post_count = $this->posts()->published()->count();
        $this->save();
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
