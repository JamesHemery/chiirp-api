<?php

declare(strict_types=1);

namespace App\Models;

use App\Models\Traits\ConvertDateTimeToUTC;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use YieldStudio\EloquentPublicId\HasPublicId;

/**
 * @property Carbon|null $login_code_expires_at
 */
class User extends Authenticatable
{
    use ConvertDateTimeToUTC, HasApiTokens, HasFactory, HasPublicId, Notifiable;

    public const int LOGIN_CODE_DURATION_IN_MINUTES = 5;

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
}
