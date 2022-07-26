<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Models;

use ARKEcosystem\Foundation\Blog\Models\Factories\UserFactory;
use ARKEcosystem\Foundation\Fortify\Models\User as BaseUser;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends BaseUser implements HasMedia
{
    use HasSlug;
    use HasFactory;
    use Notifiable;
    use InteractsWithMedia;
    use SoftDeletes;

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function articles(): HasMany
    {
        return $this->hasMany(Article::class, 'user_id');
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('name')
            ->saveSlugsTo('name_slug');
    }

    public function photo() : string
    {
        $photo = $this->getFirstMediaUrl('photo');

        if ($photo === '') {
            return '/images/user/placeholder-photo.png';
        }

        return $photo;
    }

    public function registerMediaCollections() : void
    {
        $this->addMediaCollection('photo')->singleFile();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return new UserFactory();
    }
}
