<?php

declare(strict_types=1);

namespace App\Http\Requests\Messages;

use App\Models\Message;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class ReadAudioMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        /** @var User $user */
        $user = $this->user();
        $message = $this->getMessage();

        return auth('sanctum')->check() && ! is_null($message) && $message->receivedBy($user);
    }

    public function rules(): array
    {
        return [];
    }

    public function getMessage(): ?Message
    {
        /** @var Message|null $message */
        $message = $this->route('message');

        return $message;
    }
}
