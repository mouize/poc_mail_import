<?php

declare(strict_types=1);

namespace App\Services\MailImporter\Connectors;

use App\Jobs\ConnectorGetData;
use App\Models\EmailContext;

trait GoogleTrait
{
    public function callNextGoogle(): void
    {
        ConnectorGetData::dispatch(
            new static(),
            EmailContext::findByUserId($this->userId),
            ['pageToken' => $this->nextPage]
        )->delay(now()->addSecond());
    }

    public function getPageToken(): ?string
    {
        return $this->extra['pageToken'] ?? null;
    }
}
