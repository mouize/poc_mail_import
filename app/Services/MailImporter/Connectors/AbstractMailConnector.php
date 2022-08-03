<?php

declare(strict_types=1);

namespace App\Services\MailImporter\Connectors;

use App\Models\EmailMessage;
use App\Services\MailImporter\MailConnectorInterface;
use Carbon\Carbon;
use Illuminate\Support\Collection;

abstract class AbstractMailConnector implements MailConnectorInterface
{
    protected ?Carbon $dateBegin = null;
    protected ?Carbon $dateEnd = null;
    protected ?string $nextPage = null;
    protected Collection $data;
    protected int $userId;
    protected array $extra = [];

    public function __construct()
    {
        $this->data = collect([]);
    }

    public function save(): void
    {
        if ($this->data->isEmpty()) {
            return;
        }

        EmailMessage::insert($this->data->toArray());
    }

    public function hasPagination(): bool
    {
        return !empty($this->nextPage);
    }

    public function setDateBegin(?Carbon $dateBegin): static
    {
        $this->dateBegin = $dateBegin;

        return $this;
    }

    public function setDateEnd(?Carbon $dateEnd): static
    {
        $this->dateEnd = $dateEnd;

        return $this;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;

        return $this;
    }

    public function getExtra(): array
    {
        return $this->extra;
    }

    /**
     * @return AbstractMailConnector
     */
    public function setExtra(array $extra): static
    {
        $this->extra = $extra;

        return $this;
    }
}
