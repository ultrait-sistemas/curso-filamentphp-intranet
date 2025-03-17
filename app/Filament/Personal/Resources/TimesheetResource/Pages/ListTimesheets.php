<?php

namespace App\Filament\Personal\Resources\TimesheetResource\Pages;

use App\Filament\Personal\Resources\TimesheetResource;
use App\Models\Timesheet;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\Auth;

class ListTimesheets extends ListRecords
{
    protected static string $resource = TimesheetResource::class;

    protected function getHeaderActions(): array
    {
        $lastTimesheet = Timesheet::where('user_id', Auth::user()->id)->orderBy('id','desc')->first();
        return [
            Action::make('inWork')
                ->label('Entrar a Trabajar')
                ->color('success')
                ->visible(!$lastTimesheet || !$lastTimesheet->day_out == null)
                ->disabled($lastTimesheet && $lastTimesheet->day_out == null)
                ->requiresConfirmation()
                ->action(function (){
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 1;
                    $timesheet->user_id = Auth::user()->id;
                    $timesheet->day_in = Carbon::now();
                    $timesheet->type = 'work';
                    $timesheet->save();

                    Notification::make()
                        ->title('Has entrado a trabajar')
                        ->body('Has comenzado a trabajar a las '.Carbon::now())
                        ->success()
                        ->color('success')
                        ->send();
                }),
            Action::make('stopWork')
                ->label('Parar de Trabajar')
                ->color('danger')
                ->visible($lastTimesheet && $lastTimesheet->type == 'work' && $lastTimesheet->day_out == null)
                ->disabled(!($lastTimesheet && $lastTimesheet->type == 'work' && $lastTimesheet->day_out == null))
                ->requiresConfirmation()
                ->action(function () use($lastTimesheet) {
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();

                    Notification::make()
                        ->title('Has salido de trabajar')
                        ->body('Has parado de trabajar a las '.Carbon::now())
                        ->success()
                        ->color('success')
                        ->send();
                }),
            Action::make('inPause')
                ->label('Iniciar Pausa')
                ->color('info')
                ->visible($lastTimesheet && $lastTimesheet->type == 'work' && $lastTimesheet->day_out == null)
                ->disabled(!($lastTimesheet && $lastTimesheet->type == 'work' && $lastTimesheet->day_out == null))
                ->requiresConfirmation()
                ->action(function() use($lastTimesheet){
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 1;
                    $timesheet->user_id = Auth::user()->id;
                    $timesheet->day_in = Carbon::now();
                    $timesheet->type = 'pause';
                    $timesheet->save();

                    Notification::make()
                        ->title('Has pausado tu trabajo')
                        ->body('Has pausado tu trabajo a las '.Carbon::now())
                        ->info()
                        ->color('info')
                        ->send();
                }),
            Action::make('stopPause')
                ->label('Parar Pausa')
                ->color('info')
                ->visible($lastTimesheet && $lastTimesheet->type == 'pause' && $lastTimesheet->day_out == null)
                ->disabled(!($lastTimesheet && $lastTimesheet->type == 'pause' && $lastTimesheet->day_out == null))
                ->requiresConfirmation()
                ->action(function() use($lastTimesheet){
                    $lastTimesheet->day_out = Carbon::now();
                    $lastTimesheet->save();
                    $timesheet = new Timesheet();
                    $timesheet->calendar_id = 1;
                    $timesheet->user_id = Auth::user()->id;
                    $timesheet->day_in = Carbon::now();
                    $timesheet->type = 'work';
                    $timesheet->save();

                    Notification::make()
                        ->title('Has reanudado tu trabajo')
                        ->body('Has reanudado tu trabajo a las '.Carbon::now())
                        ->info()
                        ->color('info')
                        ->send();
                }),
            Actions\CreateAction::make(),
        ];
    }

}
