<?php

namespace App\Filament\Resources\ProjectLabelTaskResource\Pages;

use App\Filament\Resources\ProjectLabelTaskResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageProjectLabelTasks extends ManageRecords
{
    protected static string $resource = ProjectLabelTaskResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
