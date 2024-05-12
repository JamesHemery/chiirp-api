<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use YieldStudio\EloquentPublicId\HasPublicId;

/**
 * @property Carbon|null $listened_at
 * @property Carbon|null $erased_at
 */
class Message extends BaseModel implements HasMedia
{
    use HasPublicId, InteractsWithMedia;

    public const string AUDIO_FILE_COLLECTION = 'audio_file';

    public const int EXPIRES_AFTER_MINUTES = 5;

    protected $fillable = ['receiver_id', 'sender_id', 'erased_at', 'listened_at'];

    protected function casts(): array
    {
        return [
            'listened_at' => 'datetime',
            'erased_at' => 'datetime',
        ];
    }

    public function receivedBy(User $user): bool
    {
        return $user->is($this->receiver);
    }

    /**
     * @return Attribute<Media|null, never>
     */
    protected function audioFile(): Attribute
    {
        return Attribute::get(fn () => $this->getFirstMedia(self::AUDIO_FILE_COLLECTION));
    }

    /**
     * @return BelongsTo<User, Message>
     */
    public function sender(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo<User, Message>
     */
    public function receiver(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection(self::AUDIO_FILE_COLLECTION)
            ->acceptsMimeTypes(['application/octet-stream'])
            ->singleFile();
    }
}
