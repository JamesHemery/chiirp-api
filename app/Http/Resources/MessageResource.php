<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Message
 */
class MessageResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->public_id,
            'created_at' => $this->created_at,
            'listened_at' => $this->listened_at,
            'sender' => BuddyResource::make($this->whenLoaded('sender')),
        ];
    }
}
