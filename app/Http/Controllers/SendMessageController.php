<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Exceptions\CantSendMessageToYourself;
use App\Exceptions\InvalidMessageContentSignature;
use App\Http\Requests\SendMessageRequest;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Http\UploadedFile;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;

class SendMessageController extends Controller
{
    /**
     * @throws FileIsTooBig
     * @throws FileDoesNotExist
     * @throws CantSendMessageToYourself
     * @throws InvalidMessageContentSignature
     */
    public function __invoke(SendMessageRequest $request): Response
    {
        $receiver = $request->getReceiver();

        /** @var User $user */
        $user = $request->user('sanctum');

        if ($receiver->is($user)) {
            throw new CantSendMessageToYourself();
        }

        /** @var UploadedFile $content */
        $content = $request->file('content');

        $this->verifySenderIdentity(
            $user->public_key,
            $content->getContent(),
            $request->string('signature')->toString()
        );

        $message = $receiver->receivedMessages()->create([
            'sender_id' => $user->id,
        ]);

        $message->addMediaFromRequest('content')->toMediaCollection(Message::AUDIO_FILE_COLLECTION);

        MessageSent::dispatch($message);

        return response()->noContent();
    }

    private function verifySenderIdentity(string $senderPublicKey, string $encryptedContent, string $signature): void
    {
        $signature = base64_decode($signature);
        $isValidSignature = openssl_verify($encryptedContent, $signature, $senderPublicKey) === 1;

        if ($isValidSignature === false) {
            throw new InvalidMessageContentSignature();
        }
    }
}
