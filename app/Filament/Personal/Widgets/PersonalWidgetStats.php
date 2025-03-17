<?php

namespace App\Filament\Personal\Widgets;

use App\Models\Holiday;
use App\Models\Timesheet;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class PersonalWidgetStats extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Pending Holidays', $this->countHolidaysByType(Auth::user(), 'pending')),
            Stat::make('Approved Holidays', $this->countHolidaysByType(Auth::user(), 'approved')),
            Stat::make('Total Woorked', $this->countTotalWork(Auth::user())),
        ];
    }

    protected function countHolidaysByType(User $user, string $type)
    {
        $totalPendingHolidays = Holiday::where('user_id', $user->id)
                                       ->where('type', $type)
                                       ->get()->count();
        return $totalPendingHolidays;
    }

    protected function countTotalWork(User $user)
    {
        $timesheets = Timesheet::where('user_id', $user->id)
                                        ->where('type', 'work')
                                        ->get()->count();
        return $timesheets;
    }
}
