<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return ! auth()->check();
    }

    public function rules(): array
    {
        return [
            'email' => 'required|email:rfc,dns',
            'code' => 'required|string|size:6',
            'user_agent' => 'required|string|max:255',
        ];
    }
}
