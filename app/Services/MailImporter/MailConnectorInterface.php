<?php

declare(strict_types=1);

namespace App\Services\MailImporter;

interface MailConnectorInterface
{
    public function listEmails(): void;

    public function save(): void;

    public function hasPagination(): bool;

    public function callNextPages(): void;
}
