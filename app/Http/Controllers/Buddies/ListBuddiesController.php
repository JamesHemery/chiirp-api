<?php

declare(strict_types=1);

namespace App\Http\Controllers\Buddies;

use App\Http\Requests\Buddies\ListBuddiesRequest;
use App\Http\Resources\BuddyResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListBuddiesController
{
    public function __invoke(ListBuddiesRequest $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user('sanctum');

        return BuddyResource::collection($user->buddies);
    }
}
