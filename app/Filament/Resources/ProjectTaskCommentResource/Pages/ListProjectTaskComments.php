<?php

namespace App\Filament\Resources\ProjectTaskCommentResource\Pages;

use App\Filament\Resources\ProjectTaskCommentResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProjectTaskComments extends ListRecords
{
    protected static string $resource = ProjectTaskCommentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
