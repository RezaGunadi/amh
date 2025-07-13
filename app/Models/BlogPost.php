<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class BlogPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'svg_icon',
        'category',
        'author_name',
        'author_avatar',
        'reading_time',
        'views',
        'is_featured',
        'is_published',
        'published_at'
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'published_at' => 'datetime',
        'reading_time' => 'integer',
        'views' => 'integer'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($post) {
            if (empty($post->slug)) {
                $post->slug = Str::slug($post->title);
            }
            if (empty($post->published_at) && $post->is_published) {
                $post->published_at = now();
            }
        });
    }

    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function getFormattedReadingTimeAttribute()
    {
        return $this->reading_time . ' menit baca';
    }

    public function getFormattedPublishedDateAttribute()
    {
        return $this->published_at ? $this->published_at->diffForHumans() : 'Draft';
    }

    public function incrementViews()
    {
        $this->increment('views');
    }

    public function getCategoryDisplayNameAttribute()
    {
        $categories = [
            'tips-belajar' => 'Tips Belajar',
            'pendidikan' => 'Pendidikan',
            'teknologi' => 'Teknologi',
            'motivasi' => 'Motivasi',
            'karir' => 'Karir',
            'komunitas' => 'Komunitas'
        ];

        return $categories[$this->category] ?? ucfirst($this->category);
    }

    public function getCategoryBadgeColorAttribute()
    {
        $colors = [
            'tips-belajar' => 'primary',
            'pendidikan' => 'success',
            'teknologi' => 'info',
            'motivasi' => 'warning',
            'karir' => 'danger',
            'komunitas' => 'secondary'
        ];

        return $colors[$this->category] ?? 'primary';
    }
}
