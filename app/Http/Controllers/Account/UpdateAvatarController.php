<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UpdateAvatarRequest;
use App\Models\User;
use Illuminate\Http\Response;

class UpdateAvatarController extends Controller
{
    public function __invoke(UpdateAvatarRequest $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        $user->addMediaFromRequest('avatar')->toMediaCollection(User::AVATAR_COLLECTION);

        return response()->noContent();
    }
}
