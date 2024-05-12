<?php

declare(strict_types=1);

namespace App\Http\Controllers\Buddies;

use App\Http\Requests\Buddies\DeleteBuddyRequest;
use App\Models\User;
use Illuminate\Http\Response;

class DeleteBuddyController
{
    public function __invoke(DeleteBuddyRequest $request, User $buddy): Response
    {
        /** @var User $user */
        $user = $request->user('sanctum');

        $user->buddies()->detach($buddy);
        $buddy->buddies()->detach($user);

        return response()->noContent();
    }
}
