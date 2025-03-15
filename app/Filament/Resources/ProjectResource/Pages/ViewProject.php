<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewProject extends ViewRecord
{
    protected static string $resource = ProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('board')
                ->label('View Board')
                ->url(fn() => self::$resource::getUrl('board', ['record' => $this->record])),
            Actions\EditAction::make(),

        ];
    }
}
