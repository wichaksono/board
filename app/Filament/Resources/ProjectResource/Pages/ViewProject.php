<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Notifications\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ViewRecord;

use function auth;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('send-notification')
                ->label('Send Notification')
                ->action(function () {
                    $user = auth()->user();
                    Notification::make()
                        ->title('User Baru Terdaftar')
                        ->body('User ' . $user->name . ' telah mendaftar')
                        ->actions([
                            Action::make('view')
                                ->label('Lihat User')
                                ->url(UserResource::getUrl('edit', ['record' => $user->id]))
                                ->link()
                                ->icon('heroicon-m-pencil-square'),
                        ])
                        ->sendToDatabase($user, isEventDispatched: true);
                }),
            Actions\Action::make('board')
                ->label('View Board')
                ->url(fn() => self::$resource::getUrl('board', ['record' => $this->record])),
            Actions\EditAction::make(),

        ];
    }
}
