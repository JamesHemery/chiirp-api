<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Exceptions\BadLoginCode;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request): JsonResponse
    {
        $email = $request->string('email')->toString();
        $code = $request->string('code')->toString();
        $agent = $request->string('user_agent')->toString();

        $user = User::where('email', $email)->first();

        if (filled($user) && $user->login_code_expires_at?->isFuture() && $user->login_code === $code) {
            $user->login_code = null;
            $user->login_code_expires_at = null;
            $user->save();

            return response()->json([
                'token' => $user->createToken($agent)->plainTextToken,
            ]);
        }

        throw new BadLoginCode();
    }
}
