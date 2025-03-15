<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\KanbanBoard\Resources\KanbanBoard;
use App\Filament\Resources\ProjectResource;
use App\Models\Project;
use App\Models\ProjectTask;
use Filament\Actions\CreateAction;
use Filament\Forms;
use Illuminate\Support\Collection;

use function array_combine;
use function collect;

class ProjectBoard extends KanbanBoard
{

    protected static string $resource = ProjectResource::class;

    public Project $record;

    public static ?Project $project = null;

    protected function statuses(): Collection
    {
        $boards = $this->record->boards;

        $collection = collect();

        foreach ($boards as $board) {
            $collection->push([
                'id' => $board,
                'title' => $board,
            ]);
        }

        return $collection;
    }

    protected function records(): Collection
    {
        return ProjectTask::where('project_id', $this->record->id)
            ->orderBy('order_column')
            ->get();
    }

    public function onStatusChanged(
        string|int $recordId,
        string $status,
        array $fromOrderedIds,
        array $toOrderedIds
    ): void {
        ProjectTask::find($recordId)->update(['status' => $status]);
        ProjectTask::setNewOrder($toOrderedIds);
    }

    public function onSortChanged(string|int $recordId, string $status, array $orderedIds): void
    {
        ProjectTask::setNewOrder($orderedIds);
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalHeading('Create Task:' . $this->record->title)
                ->model(ProjectTask::class)
                ->form([
                    Forms\Components\Hidden::make('project_id')
                        ->default($this->record->id),

                    Forms\Components\TextInput::make('title')
                        ->required()
                        ->maxLength(255),

                    Forms\Components\Textarea::make('description')
                        ->columnSpanFull(),

                    Forms\Components\DatePicker::make('start_date'),

                    Forms\Components\DatePicker::make('due_date'),

                    Forms\Components\Select::make('milestone_id')
                        ->relationship('milestone', 'title'),

                    Forms\Components\Select::make('status')
                        ->options(function () {
                            return array_combine($this->record->boards, $this->record->boards);
                        }),

                    Forms\Components\Select::make('priority')
                        ->options(function () {
                            return array_combine($this->record->priorities, $this->record->priorities);
                        }),
                ])
                ->mutateFormDataUsing(function ($data) {
                    $data['user_id'] = auth()->id();

                    return $data;
                }),
        ];
    }
}
