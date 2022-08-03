<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Log;

class EmailContext extends Model
{
    use HasFactory;

    protected $fillable = ['date_begin', 'date_end', 'week_hours', 'hour_begin', 'hour_end', 'user_id'];

    protected $casts = [
        'date_begin' => 'datetime:Y-m-d H:i:s',
        'date_end' => 'datetime:Y-m-d H:i:s',
    ];

    public static function calculateHourEnd(?string $hourBegin, ?int $weekHours): ?string
    {
        Log::debug($hourBegin);
        Log::debug($weekHours);
        $hourEnd = null;
        if (!empty($weekHours) && !empty($hourBegin)) {
            $hourPerDay = $weekHours / 5;

            $hBegin = Carbon::createFromFormat('H:i', $hourBegin);

            $hourEnd = $hBegin->addRealHours($hourPerDay)->format('H:i');
        }

        return $hourEnd;
    }

    public static function findByUserId(int $userId): ?static
    {
        return static::where('user_id', $userId)->first();
    }
}
