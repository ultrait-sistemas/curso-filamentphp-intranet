<?php

namespace App\Filament\Resources\HolidayResource\Pages;

use App\Filament\Resources\HolidayResource;
use App\Mail\HolidayApproved;
use App\Mail\HolidayDeclined;
use App\Mail\HolidayPending;
use App\Models\User;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Mail;


class EditHoliday extends EditRecord
{
    protected static string $resource = HolidayResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

    protected function handleRecordUpdate(Model $record, array $data): Model
    {
        $record->update($data);
        //dd($record, $data);

        $user = User::find($data['user_id']);
        $dataToSend = array(
            'day' => $data['day'],
            'name' => $user->name,
            'email' => $user->email,
        );

        if($data['type'] == 'approved') {
            Mail::to($user)->send(new HolidayApproved($dataToSend));

            Notification::make()
                ->title('Solicitud de vacaciones Aprobada')
                ->body("Tu solicitud de vacaciones por el dia {$data['day']} ha sido <strong>APROBADA</string>")
                ->success()
                ->sendToDatabase($user); 

        } elseif($data['type'] == 'declined') {
            Mail::to($user)->send(new HolidayDeclined($dataToSend));

            Notification::make()
                ->title('Solicitud de vacaciones Rechazada')
                ->body("Tu solicitud de vacaciones por el dia {$data['day']} ha sido <strong>RECHAZADA</string>")
                ->danger()
                ->sendToDatabase($user); 

        }

        return $record;
    }

    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }
}
