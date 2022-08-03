<?php

declare(strict_types=1);

namespace App\Services\MailImporter\Connectors;

use App\Enums\MailImporter as EnumMailImporter;
use App\Services\MailImporter\Exceptions\GmailImportException;
use Carbon\Carbon;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;
use Dacastro4\LaravelGmail\Services\Message;
use Dacastro4\LaravelGmail\Services\Message\Mail;
use Dacastro4\LaravelGmail\Services\MessageCollection;
use Exception;
use Illuminate\Support\Facades\Log;

class GmailConnector extends AbstractMailConnector
{
    use GoogleTrait;

    public const SCOPE_GMAIL_READONLY = 'https://www.googleapis.com/auth/gmail.readonly';

    public function listEmails(): void
    {
        /*
         * @var MessageCollection $messages
         *
         * As we are in a job and there is no context,
         * we have to load a user so the LaravelGmail can find the current user to load
         */
        LaravelGmail::setUserId($this->userId);

        $messageBuilder = LaravelGmail::message();
        if (null !== $this->dateBegin) {
            $messageBuilder->after($this->dateBegin->unix());
        }

        if (null !== $this->dateEnd) {
            $messageBuilder->before($this->dateEnd->unix());
        }

        try {
            $messages = $messageBuilder
                ->from(LaravelGmail::user())
                ->preload()
                ->all($this->getPageToken());
        } catch (Exception $e) {
            throw new GmailImportException($e->getMessage());
        }

        foreach ($messages as $message) {
            try {
                $data = $this->extractDataFromMessage($message);

                $data['type'] = EnumMailImporter::EMAIL_TYPE;
                $data['user_id'] = $this->userId;
                $data['created_at'] = $data['updated_at'] = Carbon::now();
                $this->data->add($data);
            } catch (Exception $e) {
                // Skip error that can be thrown due to the Gmail bundle. Minor issues.
                Log::error($e->getMessage());
            }
        }

        if (true === $messages->hasNextPage()) {
            // @todo : update when the pageToken method will be available.
            $extra = (array) $messages;

            foreach ($extra as $value) {
                if ($value instanceof Message) {
                    $this->nextPage = $value->pageToken;
                }
            }
        }
    }

    public function callNextPages(): void
    {
        $this->callNextGoogle();
    }

    protected function extractDataFromMessage(Mail $mail): array
    {
        $fieldsToTransform = ['to', 'cc', 'bcc'];

        $email['subject'] = $mail->getSubject();
        $email['body'] = $mail->getBody();
        $email['from'] = $this->extractEmailName($mail->getFrom());
        $email['date'] = $mail->getDate();

        foreach ($fieldsToTransform as $field) {
            $getter = 'get'.ucfirst($field);
            $email[$field] = $this->transformExchangersToStrings($mail->{$getter}());
        }

        return $email;
    }

    protected function transformExchangersToStrings(?array $emails): string
    {
        if (null === $emails) {
            return '';
        }

        $return = [];
        foreach ($emails as $email) {
            if ($this->extractEmailName($email)) {
                $return[] .= $this->extractEmailName($email);
            }
        }

        return implode(', ', $return);
    }

    protected function extractEmailName(array $email): string
    {
        return $email['name'] && $email['email'] ? '['.$email['name'].'] '.$email['email'] : '';
    }
}
