<?php

namespace App\Filament\Resources\ProjectTaskCommentResource\Pages;

use App\Filament\Resources\ProjectTaskCommentResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProjectTaskComment extends EditRecord
{
    protected static string $resource = ProjectTaskCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
