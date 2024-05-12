<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UpdateAccountRequest;
use App\Models\User;
use Illuminate\Http\Response;

class UpdateAccountController extends Controller
{
    public function __invoke(UpdateAccountRequest $request): Response
    {
        /** @var User $user */
        $user = $request->user('sanctum');

        $user->update($request->validated());

        return response()->noContent();
    }
}
