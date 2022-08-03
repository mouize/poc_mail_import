<?php

declare(strict_types=1);

namespace App\Http\Livewire;

use App\Jobs\ConnectorGetData;
use App\Models\EmailContext;
use App\Models\EmailMessage;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use LaravelGmail;
use Livewire\Component;

class MainPage extends Component
{
    public ?string $date_begin;
    public ?string $date_end;
    public int $user_id;
    public ?string $hour_begin;
    public ?string $hour_end;
    public null|string|int $week_hours;
    public ?EmailContext $context;

    protected array $rules = [
        'date_begin' => ['required', 'date'],
        'date_end' => ['required', 'date'],
        'user_id' => ['required', 'int'],
        'hour_begin' => ['required', 'date_format:H:i'],
        'hour_end' => ['required', 'date_format:H:i'],
        'week_hours' => ['required', 'int'],
    ];

    public function mount(): void
    {
        $now = Carbon::now();
        $this->user_id = Auth::user()->id;

        $this->context = EmailContext::findByUserId($this->user_id);

        $this->date_end = $this->context?->date_end?->format('Y-m-d') ?? $now->format('Y-m-d');
        $this->date_begin = $this->context?->date_begin?->format('Y-m-d')
            ?? $now->subYears(3)->startOfYear()->format('Y-m-d');

        $this->week_hours = $this->context?->week_hours ?? config('custom.week_hours');
        $this->hour_begin = $this->context?->hour_begin ?? config('custom.hour_begin');
        $this->hour_end = $this->context?->hour_end ?? config('custom.hour_end');
    }

    public function export(): void
    {
        EmailMessage::deleteByUserId(Auth::id());

        // Launch a list of jobs for each provider.
        $connectors = Auth::user()->getConnectors();

        foreach ($connectors as $connector) {
            ConnectorGetData::dispatch($connector, $this->context);
        }

        session()->flash('export_message', 'L\'export a été lancé et sera disponible dans quelques instants');
    }

    public function render()
    {
        /*
         * Need to fix the lost of email in the token. Might be from the refreshToken method.
         * So let's logout the user so he can login again
         */
        if (true === LaravelGmail::check() && null === LaravelGmail::user()) {
            LaravelGmail::logout();

            return redirect(Request::url());
        }

        $blockClass = (true === LaravelGmail::check()) ? 'border-4 border-indigo-500/100' : 'bg-grey-700';

        return view('livewire.main-page', ['blockClass' => $blockClass]);
    }

    public function submit(): void
    {
        $this->validate();

        EmailContext::updateOrCreate(
            ['user_id' => $this->user_id],
            [
                'date_begin' => $this->date_begin,
                'date_end' => $this->date_end,
                'hour_begin' => $this->hour_begin,
                'hour_end' => $this->hour_end,
                'week_hours' => $this->week_hours,
            ]
        );

        session()->flash('config_message', 'Configuration sauvegardé');
    }

    /**
     * Event used by Limewire.
     */
    public function updatedWeekHours(): void
    {
        $this->calculateHourEnd();
    }

    /**
     * Event used by Limewire.
     */
    public function updatedHourBegin(): void
    {
        $this->calculateHourEnd();
    }

    public function calculateHourEnd(): void
    {
        $this->hour_end = EmailContext::calculateHourEnd($this->hour_begin, (int) $this->week_hours);
    }
}
