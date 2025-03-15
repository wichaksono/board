<?php

namespace App\Filament\Resources\ProjectTaskResource\Pages;

use App\Filament\Resources\ProjectTaskResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;

use function auth;

class CreateProjectTask extends CreateRecord
{
    protected static string $resource = ProjectTaskResource::class;

    public static string|Alignment $formActionsAlignment = Alignment::End;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }
}
