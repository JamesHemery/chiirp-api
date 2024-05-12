<?php

declare(strict_types=1);

namespace App\Http\Requests\Buddies;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;

class AddBuddyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return [
            'buddy_id' => 'required|exists:users,public_id',
        ];
    }

    public function getUserToAdd(): User
    {
        /** @var User $user */
        $user = User::findByPublicId($this->string('buddy_id')->toString());

        return $user;
    }
}
