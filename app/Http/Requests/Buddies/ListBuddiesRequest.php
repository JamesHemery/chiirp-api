<?php

declare(strict_types=1);

namespace App\Http\Requests\Buddies;

use Illuminate\Foundation\Http\FormRequest;

class ListBuddiesRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('sanctum')->check();
    }

    public function rules(): array
    {
        return [];
    }
}
