<?php

namespace App\Filament\Resources\ProjectResource\Pages;

use App\Filament\Resources\ProjectResource;
use Filament\Resources\Pages\Page;
use App\Models\Project;

class ProjectBoard extends Page
{
    protected static string $resource = ProjectResource::class;

    protected static string $view = 'filament.resources.projects.board';

    public Project $record;
}
