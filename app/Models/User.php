<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\ConvertDateTimeToUTC;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use YieldStudio\EloquentPublicId\HasPublicId;

/**
 * @property Carbon|null $login_code_expires_at
 */
class User extends Authenticatable implements HasMedia
{
    use ConvertDateTimeToUTC;
    use HasApiTokens;
    use HasFactory;
    use HasPublicId;
    use InteractsWithMedia;
    use Notifiable;

    public const int LOGIN_CODE_DURATION_IN_MINUTES = 5;

    public const string AVATAR_COLLECTION = 'avatar';

    public const string REGULAR_AVATAR_CONVERSION = 'regular';

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'login_code_expires_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * @return Attribute<Media|null, never>
     */
    protected function avatar(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMedia(self::AVATAR_COLLECTION));
    }

    /**
     * @return BelongsToMany<User>
     */
    public function buddies(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'buddies', 'user_id', 'buddy_id');
    }

    /**
     * @return HasMany<Message>
     */
    public function sentMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'sender_id');
    }

    /**
     * @return HasMany<Message>
     */
    public function receivedMessages(): HasMany
    {
        return $this->hasMany(Message::class, 'receiver_id');
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion(self::REGULAR_AVATAR_CONVERSION)
            ->performOnCollections(self::AVATAR_COLLECTION)
            ->fit(Fit::Max, 128, 128)
            ->format('jpeg')
            ->optimize();
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::AVATAR_COLLECTION)
            ->acceptsMimeTypes(['image/jpeg', 'image/jpg', 'image/png'])
            ->singleFile();
    }
}
