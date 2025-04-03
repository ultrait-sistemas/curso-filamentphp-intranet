<?php

namespace App\Filament\Personal\Resources\HolidayResource\Pages;

use App\Filament\Personal\Resources\HolidayResource;
use App\Mail\HolidayPending;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class CreateHoliday extends CreateRecord
{
    protected static string $resource = HolidayResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = Auth::user()->id;
        $data['type'] = 'pending';
        $userAdmin = User::find(2);

        $employee = User::find($data['user_id']);
        $dataToSend = array(
            'day' => $data['day'],
            'name' => $employee->name,
            'email' => $employee->email,
        );
        Mail::to($userAdmin)->send(new HolidayPending($dataToSend));
        
        $recipient = Auth::user();

        Notification::make()
            ->title('Solicitud de vacaciones')
            ->body("Ha solicitado el dia {$data['day']} de vacaciones")
            ->sendToDatabase($recipient);

        return $data;
    }   
    
    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
