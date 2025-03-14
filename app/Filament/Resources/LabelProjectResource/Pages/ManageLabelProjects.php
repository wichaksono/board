<?php

namespace App\Filament\Resources\LabelProjectResource\Pages;

use App\Filament\Resources\LabelProjectResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Filament\Support\Enums\Alignment;
use Illuminate\Support\Str;

class ManageLabelProjects extends ManageRecords
{
    protected static string $resource = LabelProjectResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->createAnother(false)
                ->modalFooterActionsAlignment(Alignment::End)
                ->modalWidth('md')
                ->mutateFormDataUsing(function (array $data) {
                    $data['slug'] = Str::slug($data['name']);
                    return $data;
                }),
        ];
    }
}
