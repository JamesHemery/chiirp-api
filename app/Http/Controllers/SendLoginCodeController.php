<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\SendLoginCodeRequest;
use App\Mail\LoginCode;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Mail;

class SendLoginCodeController extends Controller
{
    public function __invoke(SendLoginCodeRequest $request): Response
    {
        $email = $request->string('email')->toString();

        $user = User::where('email', $email)->first();
        if (filled($user)) {
            $this->sendLoginCode($user);
        }

        return response()->noContent();
    }

    private function sendLoginCode(User $user): void
    {
        if ($this->shouldResetLoginCode($user)) {
            $user->login_code = (string) mt_rand(111111, 999999);
            $user->login_code_expires_at = now()->addMinutes(User::LOGIN_CODE_DURATION_IN_MINUTES);
            $user->save();
        }

        Mail::to($user)->send(new LoginCode((string) $user->login_code));
    }

    private function shouldResetLoginCode(User $user): bool
    {
        if (blank($user->login_code)) {
            return true;
        }

        if (filled($user->login_code) && filled($user->login_code_expires_at)) {
            return $user->login_code_expires_at->isPast() || now()->addMinutes(3)->isAfter($user->login_code_expires_at);
        }

        return false;
    }
}
