<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\ShowAccountRequest;
use App\Http\Resources\AccountResource;
use App\Models\User;

class ShowAccountController extends Controller
{
    public function __invoke(ShowAccountRequest $request): AccountResource
    {
        /** @var User $user */
        $user = $request->user();

        return AccountResource::make($user);
    }
}
