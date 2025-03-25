<?php

namespace App\Imports;

use App\Models\Calendar;
use App\Models\Timesheet;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MyTimesheetImport implements ToCollection, WithHeadingRow
{
    /**
    * @param Collection $collection
    */
    public function collection(Collection $rows)
    {
        
        foreach($rows as $row) {
            $calendar = Calendar::where('name', $row['calendario'])->first();

            if($calendar) {
                Timesheet::create([
                    'calendar_id' => $calendar->id,
                    'user_id' => Auth::user()->id,
                    'type' => $row['tipo'],
                    'day_in' => $row['fecha_de_ingreso'],
                    'day_out' => $row['fecha_de_salida'],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
