<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_addr',
        'title',
        'slug',
        'description',
        'website',
        'userGithub',
        'projectTwitter',
        'metadata',
        'flagged_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'owners' => 'array',
    ];

    public static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->slug = static::generateUniqueSlug($model->title);
        });

        static::updating(function ($model) {
            // Only update slug if the title has changed
            if ($model->isDirty('title')) {
                $model->slug = static::generateUniqueSlug($model->title);
            }
        });
    }

    public static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;

        $count = 2;
        while (static::whereSlug($slug)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }

    public function applications()
    {
        return $this->hasMany(RoundApplication::class, 'project_addr', 'id_addr');
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }
}
