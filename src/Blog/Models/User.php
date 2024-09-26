<?php

declare(strict_types=1);

namespace ARKEcosystem\Foundation\Blog\Models;

use ARKEcosystem\Foundation\Blog\Models\Concerns\HasLocalizedTimestamps;
use ARKEcosystem\Foundation\Blog\Models\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\PersonalDataExport\PersonalDataSelection;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class User extends Authenticatable implements HasMedia
{
    use HasSlug;
    use HasFactory;
    use HasLocalizedTimestamps;
    use Notifiable;
    use InteractsWithMedia;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array|bool
     */
    protected $guarded = false;

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

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
     * @codeCoverageIgnore
     */
    public function selectPersonalData(PersonalDataSelection $personalData): void
    {
        $personalData->add('user.json', [
            'name'  => $this->name,
            'email' => $this->email,
        ]);
    }

    /**
     * @codeCoverageIgnore
     */
    public function personalDataExportName(): string
    {
        return 'personal-data-'.Str::slug($this->name).'.zip';
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
