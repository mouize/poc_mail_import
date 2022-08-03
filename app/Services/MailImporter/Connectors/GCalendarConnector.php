<?php

declare(strict_types=1);

namespace App\Services\MailImporter\Connectors;

use App\Enums\MailImporter as EnumMailImporter;
use Carbon\Carbon;
use Google\Client;
use Google\Service\Calendar;
use Google\Service\Calendar\Event;
use Exception;

class GCalendarConnector extends AbstractMailConnector
{
    use GoogleTrait;

    public const SCOPE_GCALENDAR_EVENTS = 'https://www.googleapis.com/auth/calendar.events.readonly';

    protected ?string $pageToken = null;

    public function listEmails(): void
    {
        $client = $this->getClient();
        $service = new Calendar($client);

        $calendarId = 'primary';
        $optParams = [
            'orderBy' => 'startTime',
            'singleEvents' => true,
        ];
        if (null !== $this->getPageToken()) {
            $optParams['pageToken'] = $this->getPageToken();
        }

        if (null !== $this->dateBegin) {
            $optParams['timeMin'] = $this->dateBegin->format('c');
        }

        if (null !== $this->dateEnd) {
            $optParams['timeMax'] = $this->dateEnd->format('c');
        }

        $results = $service->events->listEvents($calendarId, $optParams);
        $events = $results->getItems();

        $this->nextPage = $results->getNextPageToken();

        /**
         * @var Event $event
         */
        foreach ($events as $event) {
            $data = $this->extractDataFromEvent($event);

            $data['user_id'] = $this->userId;
            $data['created_at'] = $data['updated_at'] = Carbon::now();

            $this->data->add($data);
        }
    }

    public function callNextPages(): void
    {
        $this->callNextGoogle();
    }

    protected function extractDataFromEvent(Calendar\Event $event): array
    {
        $return['subject'] = $event->getSummary();
        $return['body'] = $event->getDescription();
        $return['from'] = $event->getCreator()->getEmail();
        $return['date'] = Carbon::parse($event->getStart()->getDateTime());
        $return['type'] = EnumMailImporter::CALENDAR_TYPE;

        return $return;
    }

    /**
     * @see https://developers.google.com/calendar/api/quickstart/php
     */
    protected function getClient()
    {
        $client = new Client();
        $client->setApplicationName('Google Calendar connector');
        $client->setScopes(static::SCOPE_GCALENDAR_EVENTS);
        $client->setAuthConfig(storage_path('app/google-calendar/oauth-credentials.json'));

        // Load previously authorized token from a file, if it exists.
        // The file token.json stores the user's access and refresh tokens, and is
        // created automatically when the authorization flow completes for the first
        // time.
        $tokenPath = storage_path('app/gmail/tokens/gmail-json-'.$this->userId.'.json');
        if (file_exists($tokenPath)) {
            $accessToken = json_decode(file_get_contents($tokenPath), true);
            $client->setAccessToken($accessToken);
        }

        // If there is no previous token or it's expired.
        if ($client->isAccessTokenExpired()) {
            // Refresh the token if possible, else fetch a new one.
            if ($client->getRefreshToken()) {
                $client->fetchAccessTokenWithRefreshToken($client->getRefreshToken());
            } else {
                throw new Exception('Token is missing, Oauth first');
            }

            // Save the token to a file.
            if (!file_exists(dirname($tokenPath))) {
                mkdir(dirname($tokenPath), 0700, true);
            }
            file_put_contents($tokenPath, json_encode($client->getAccessToken()));
        }

        return $client;
    }
}
