<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Alignment;

class EditProject extends EditRecord
{
    protected static string $resource = ProjectResource::class;

    public static string | Alignment $formActionsAlignment = Alignment::End;

    protected function getHeaderActions(): array
    {
        return [];
    }
}
