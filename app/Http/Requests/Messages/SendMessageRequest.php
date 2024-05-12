<?php

declare(strict_types=1);

namespace App\Http\Requests\Messages;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class SendMessageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('sanctum')->check();
    }

    public function rules(): array
    {
        return [
            'receiver_id' => 'required|exists:users,public_id',
            'content' => 'required|file|max:30720|mimetypes:application/octet-stream',
            'signature' => 'required|string',
        ];
    }

    public function getReceiver(): User
    {
        /** @var User $user */
        $user = User::findByPublicId($this->string('receiver_id')->toString());

        return $user;
    }
}
