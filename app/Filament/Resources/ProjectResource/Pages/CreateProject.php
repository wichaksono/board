<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use App\Models\Project;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Alignment;

/**
 * @property Project $record;
 */
class CreateProject extends CreateRecord
{
    protected static string $resource = ProjectResource::class;

    public static string|Alignment $formActionsAlignment = Alignment::End;

    protected static bool $canCreateAnother = false;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['priorities'] = Project::DEFAULT_PRIORITIES;
        $data['boards']     = Project::DEFAULT_BOARDS;
        $data['user_id']    = auth()->id();
        return $data;
    }

    public function afterCreate(): void
    {
//        if (isset($this->data['milestones']) && is_array($this->data['milestones'])) {
//            $this->record->milestones()->createMany($this->data['milestones']);
//        }
    }
}
