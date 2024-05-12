<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use YieldStudio\EloquentPublicId\HasPublicId;

class Message extends BaseModel implements HasMedia
{
    use HasPublicId, InteractsWithMedia;

    public const string AUDIO_FILE_COLLECTION = 'audio_file';

    protected $fillable = ['receiver_id', 'sender_id', 'erased_at', 'listened_at'];

    protected function casts(): array
    {
        return [
            'listened_at' => 'datetime',
            'erased_at' => 'datetime',
        ];
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
