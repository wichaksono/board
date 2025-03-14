<?php

namespace App\Filament\Resources\LabelProjectResource\Pages;

use App\Filament\Resources\LabelProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageLabelProjects extends ManageRecords
{
    protected static string $resource = LabelProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
