<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\EmailContext;
use App\Services\MailImporter\Exceptions\GmailImportException;
use App\Services\MailImporter\MailConnectorInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ConnectorGetData implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(
        protected MailConnectorInterface $mailConnector,
        protected EmailContext $context,
        protected array $extra = []
    ) {
        $this->onQueue('list_mails');
    }

    public function handle(): void
    {
        $this->mailConnector->setUserId($this->context->user_id);
        $this->mailConnector->setDateBegin($this->context->date_begin);
        $this->mailConnector->setDateEnd($this->context->date_end);
        $this->mailConnector->setExtra($this->extra);

        try {
            $this->mailConnector->listEmails();
        } catch (GmailImportException $e) {
            $this->debug($e->getMessage());

            $this->release(5);
        }

        $this->mailConnector->save();

        if (true === $this->mailConnector->hasPagination()) {
            $this->mailConnector->callNextPages();
        }
    }
}
