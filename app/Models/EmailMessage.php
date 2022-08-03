<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class EmailMessage extends Model
{
    use HasFactory;

    protected $fillable = ['subject', 'body', 'date', 'from', 'to', 'cc', 'bcc', 'user_id', 'type'];

    protected $casts = [
        'date' => 'datetime:Y-m-d H:i:s',
    ];

    public static function getEmails(int $userId): Collection
    {
        return static::where('user_id', $userId)
            ->orderByRaw('DATE(date) ASC, date DESC')
            ->get();
    }

    public static function getFirstMailsPerDay(int $userId): Collection
    {
        $table = (new static())->getTable();

        return \DB::table($table)
            ->select('id')
            ->where('user_id', $userId)
            ->whereIn('date', function ($query) use ($table): void {
                $query->select(DB::raw('min(date)'))
                    ->from($table)
                    ->groupByRaw('DATE(date)');
            })
            ->get();
    }

    public static function getLastMailsPerDay(int $userId): Collection
    {
        $table = (new static())->getTable();

        return \DB::table($table)
            ->select('id')
            ->where('user_id', $userId)
            ->whereIn('date', function ($query) use ($table): void {
                $query->select(DB::raw('max(date)'))
                    ->from($table)
                    ->groupByRaw('DATE(date)');
            })
            ->get();
    }

    public static function deleteByExcludedIds(array $ids): void
    {
        static::whereNotIn('id', $ids)->delete();
    }

    public static function deleteByUserId(int $userId): void
    {
        static::where('user_id', $userId)->delete();
    }
}
