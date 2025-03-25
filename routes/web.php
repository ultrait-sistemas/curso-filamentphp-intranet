<?php

use App\Http\Controllers\PdfController;
use Illuminate\Support\Facades\Route;
use Barryvdh\DomPDF\Facade\Pdf;

Route::get('/', function () {
    //return view('welcome');
    return redirect('/personal');
});

Route::get('/pdf/generate/timesheet/{user}', [PdfController::class, 'TimesheetRecords'])->name('pdf.generate.timesheet');
