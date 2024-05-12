<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;
use App\Http\Requests\Account\DeleteAccountRequest;
use App\Models\User;
use Illuminate\Http\Response;

class DeleteAccountController extends Controller
{
    public function __invoke(DeleteAccountRequest $request): Response
    {
        /** @var User $user */
        $user = $request->user('sanctum');

        $user->delete();

        return response()->noContent();
    }
}
