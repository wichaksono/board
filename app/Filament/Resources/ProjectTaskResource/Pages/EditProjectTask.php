<?php

namespace App\Filament\Resources\ProjectTaskResource\Pages;

use App\Filament\Resources\ProjectTaskResource;
use App\Models\Project;
use App\Models\ProjectTask;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;
use Filament\Support\Enums\Alignment;

/**
 * @property ProjectTask $record;
 */
class EditProjectTask extends EditRecord
{
    protected static string $resource = ProjectTaskResource::class;

    public static string | Alignment $formActionsAlignment = Alignment::End;

    protected function getHeaderActions(): array
    {
        return [];
    }

    protected function beforeFill(): void
    {
        $this->projectReload();
    }

    protected function afterSave(): void
    {
        $this->projectReload();
    }

    private function projectReload():void
    {
        if (!empty($this->record->project_id)) {
            self::$resource::$project = Project::find($this->record->project_id);
        }
    }
}
