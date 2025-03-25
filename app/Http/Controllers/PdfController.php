<?php

namespace App\Http\Controllers;

use App\Models\Timesheet;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PdfController extends Controller
{
    public function TimesheetRecords(User $user) {
        //dd($user);
        $timesheets = Timesheet::where('user_id', $user->id)->orderBy('day_in','desc')->get();
        $pdf = Pdf::loadView('pdf.timesheets', ['user' => $user, 'timesheets' =>$timesheets]);
        return $pdf->download('timesheets.pdf');
    }
}
