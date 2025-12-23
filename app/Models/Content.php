<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Content extends Model implements HasMedia
{
    use InteractsWithMedia;

    protected $fillable = [
        'type', 'title', 'slug', 'blocks', 'content',
        'seo_title', 'seo_description', 'cover_image',
        'is_active', 'published_at'
    ];

    protected $casts = [
        'blocks' => 'array', // Auto JSON encode/decode
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    /**
     * Scopes
     */
    public function scopePublished($query)
    {
        return $query->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeType($query, string $type)
    {
        return $query->where('type', $type);
    }

    /**
     * Auto-generate slug from title
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($content) {
            if (empty($content->slug)) {
                $content->slug = Str::slug($content->title);
            }
        });
    }

    /**
     * Media collections for cover images
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('cover')
            ->singleFile();
    }

    /**
     * Get public URL for this content
     */
    public function getPublicUrl(): string
    {
        $prefix = match($this->type) {
            'blog' => '/blog/',
            'page' => '/sayfa/',
            'faq' => '/sss/',
            'contract' => '/sozlesme/',
            default => '/sayfa/',
        };
        
        return url($prefix . $this->slug);
    }
}
