<?php

declare(strict_types=1);

namespace App\Http\Controllers\Buddies;

use App\Events\NewBuddy;
use App\Exceptions\CantAddYourselfAsBuddy;
use App\Http\Requests\Buddies\AddBuddyRequest;
use App\Models\User;
use Illuminate\Http\Response;

class AddBuddyController
{
    public function __invoke(AddBuddyRequest $request): Response
    {
        /** @var User $user */
        $user = $request->user('sanctum');

        $userToAdd = $request->getUserToAdd();

        if ($userToAdd->is($user)) {
            throw new CantAddYourselfAsBuddy();
        }

        $user->buddies()->attach($userToAdd);
        $userToAdd->buddies()->attach($user);

        NewBuddy::dispatch($user, $userToAdd);

        return response()->noContent();
    }
}
