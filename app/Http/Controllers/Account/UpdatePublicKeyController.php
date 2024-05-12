<?php

declare(strict_types=1);

namespace App\Http\Controllers\Account;

use App\Events\PublicKeyUpdated;
use App\Exceptions\InvalidPublicKey;
use App\Http\Controllers\Controller;
use App\Http\Requests\Account\UpdatePublicKeyRequest;
use App\Models\User;
use Illuminate\Http\Response;

class UpdatePublicKeyController extends Controller
{
    /**
     * @throws InvalidPublicKey
     */
    public function __invoke(UpdatePublicKeyRequest $request): Response
    {
        /** @var User $user */
        $user = $request->user();

        $publicKey = $request->string('public_key')->toString();

        $this->ensurePublicKeyIsValid($publicKey, $request->string('signature')->toString());

        $user->public_key = $publicKey;
        $user->save();

        PublicKeyUpdated::dispatch($user);

        return response()->noContent();
    }

    /**
     * To ensure that the public key is valid, we ask the client to send us a signature with the public key as content.
     * To generate the signature, the customer will use his private key.
     */
    private function ensurePublicKeyIsValid(string $publicKey, string $signature): void
    {
        $signature = base64_decode($signature);
        $isValidSignature = openssl_verify($publicKey, $signature, $publicKey) === 1;

        if ($isValidSignature === false) {
            throw new InvalidPublicKey();
        }
    }
}
