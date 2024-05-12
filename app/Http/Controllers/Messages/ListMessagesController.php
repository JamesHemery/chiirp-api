<?php

declare(strict_types=1);

namespace App\Http\Controllers\Messages;

use App\Http\Controllers\Controller;
use App\Http\Requests\Messages\ListMessagesRequest;
use App\Http\Resources\MessageResource;
use App\Models\User;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ListMessagesController extends Controller
{
    public function __invoke(ListMessagesRequest $request): AnonymousResourceCollection
    {
        /** @var User $user */
        $user = $request->user('sanctum');

        $messages = $user->receivedMessages()->whereNull('erased_at')->get();

        return MessageResource::collection($messages);
    }
}
