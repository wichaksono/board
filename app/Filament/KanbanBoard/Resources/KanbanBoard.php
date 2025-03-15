<?php

namespace App\Filament\KanbanBoard\Resources;

use App\Models\ProjectTask;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Mokhosh\FilamentKanban\Concerns\HasEditRecordModal;
use Mokhosh\FilamentKanban\Concerns\HasStatusChange;
use UnitEnum;

use function method_exists;

class KanbanBoard extends Page
{
    use HasEditRecordModal;
    use HasStatusChange;

    protected static ?string $navigationIcon = 'heroicon-o-document-text';

    protected static string $view = 'filament-kanban::kanban-board';

    protected static string $headerView = 'filament-kanban::kanban-header';

    protected static string $recordView = 'filament-kanban::kanban-record';

    protected static string $statusView = 'filament-kanban::kanban-status';

    protected static string $scriptsView = 'filament-kanban::kanban-scripts';

    protected static string $model;

    protected static string $statusEnum;

    protected static string $recordTitleAttribute = 'title';

    protected static string $recordStatusAttribute = 'status';

    public function __construct()
    {
        self::$model = ProjectTask::class;
    }

    protected function statuses(): Collection
    {
        return collect([
            ['id' => 'Todo', 'title' => 'Todo'],
            ['id' => 'In Review', 'title' => 'In Review'],
        ]);
    }

    protected function records(): Collection
    {
        return $this->getEloquentQuery()
            ->when(method_exists(static::$model, 'scopeOrdered'), fn($query) => $query->ordered())
            ->get();
    }

    protected function getViewData(): array
    {
        $records  = $this->records();
        $statuses = $this->statuses()
            ->map(function ($status) use ($records) {
                $status['records'] = $this->filterRecordsByStatus($records, $status);

                return $status;
            });
        return [
            'statuses' => $statuses,
        ];
    }

    protected function filterRecordsByStatus(Collection $records, array $status): array
    {
        $statusIsCastToEnum = $records->first()?->getAttribute(static::$recordStatusAttribute) instanceof UnitEnum;

        $filter = $statusIsCastToEnum
            ? static::$statusEnum::from($status['id'])
            : $status['id'];

        return $records->where(static::$recordStatusAttribute, $filter)->all();
    }

    protected function getEloquentQuery(): Builder
    {
        return static::$model::query();
    }
}
