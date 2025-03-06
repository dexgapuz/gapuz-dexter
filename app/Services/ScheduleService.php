<?php

namespace App\Services;

use App\Models\Schedule;
use Carbon\Carbon;

class ScheduleService
{
    public function __construct(private Schedule $schedule) {}

    public function isBakeryOpen(Carbon $datetime): bool
    {
        $openDays = [Carbon::MONDAY, Carbon::WEDNESDAY, Carbon::FRIDAY];
        $dayOfWeek = $datetime->dayOfWeek;

        if (in_array($dayOfWeek, $openDays)) {
            return $this->isWithinOpenHours($datetime, $dayOfWeek);
        }

        if ($dayOfWeek === Carbon::SATURDAY && self::isEveryOtherSaturday($datetime)) {
            return $this->isWithinOpenHours($datetime, $dayOfWeek);
        }

        return false;
    }

    private function isWithinOpenHours(Carbon $datetime, int $dayOfWeek): bool
    {
        $schedule = $this->schedule->where('day', $dayOfWeek)->first();
        $openAt = Carbon::parse($datetime->toDateString() . ' ' . $schedule->opening_time);
        $closedAt = Carbon::parse($datetime->toDateString() . ' ' . $schedule->closing_time);
        $lunchStartAt = Carbon::parse($datetime->toDateString() . ' ' . $schedule->lunch_start_time);
        $lunchCloseAt = Carbon::parse($datetime->toDateString() . ' ' . $schedule->lunch_close_time);

        return ($datetime->gte($openAt) && $datetime->lt($lunchStartAt)) || ($datetime->gte($lunchCloseAt) && $datetime->lt($closedAt));
    }

    private function isEveryOtherSaturday(Carbon $datetime): bool
    {
        $firstSaturday = Carbon::create($datetime->year, 1, 1)->next(Carbon::SATURDAY);
        $weekNumber = (int) ceil($firstSaturday->diffInWeeks($datetime) + 1);

        return $weekNumber % 2 !== 0;
    }

    public function getNextOpenDay(Carbon $datetime): array
    {
        $openDays = [Carbon::MONDAY, Carbon::WEDNESDAY, Carbon::FRIDAY];
        $currentDate = $datetime->copy();

        for ($i = 1; $i <= 7; $i++) {
            $nextDate = $currentDate->copy()->addDays($i);
            $nextDay = $nextDate->dayOfWeek;

            if (in_array($nextDay, $openDays) || ($nextDay === Carbon::SATURDAY && $this->isEveryOtherSaturday($nextDate))) {
                return [
                    'dayName' => $nextDate->format('l'),
                    'dayUntil' => $i
                ];
            }
        }

        return ['dayName' => 'Unknown', 'dayUntil' => 0];
    }
}
