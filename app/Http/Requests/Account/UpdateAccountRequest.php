<?php

declare(strict_types=1);

namespace App\Http\Requests\Account;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('sanctum')->check();
    }

    public function rules(): array
    {
        /** @var User $user */
        $user = $this->user('sanctum');

        return [
            'email' => [
                'sometimes',
                'string',
                'email:rfc,dns',
                'max:255',
                Rule::unique('users', 'email')
                    ->ignoreModel($user)
            ],
            'name' => 'sometimes|string|max:255',
        ];
    }
}
