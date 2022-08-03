<?php

declare(strict_types=1);

namespace App\Services\MailImporter;

use App\Services\MailImporter\Connectors\GCalendarConnector;
use App\Services\MailImporter\Connectors\GmailConnector;
use Dacastro4\LaravelGmail\Facade\LaravelGmail;

trait MailImporter
{
    public function getConnectors(): array
    {
        $connectors = [];

        // Check google connectors
        $scopes = LaravelGmail::getScopes();
        if (in_array(GmailConnector::SCOPE_GMAIL_READONLY, $scopes)) {
            $connectors[] = new GmailConnector();
        }

        if (in_array(GCalendarConnector::SCOPE_GCALENDAR_EVENTS, $scopes)) {
            $connectors[] = new GCalendarConnector();
        }

        return $connectors;
    }

    public static function hasGmailScope(): bool
    {
        $scopes = explode(' ', LaravelGmail::getToken()['scope']);

        return in_array(GmailConnector::SCOPE_GMAIL_READONLY, $scopes);
    }

    public static function hasGCalendarScope(): bool
    {
        $scopes = explode(' ', LaravelGmail::getToken()['scope']);

        return in_array(GCalendarConnector::SCOPE_GCALENDAR_EVENTS, $scopes);
    }
}
