<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectTaskResource\Pages;
use App\Models\Project;
use App\Models\ProjectTask;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

use function array_combine;
use function dd;
use function request;

class ProjectTaskResource extends Resource
{
    protected static ?string $model = ProjectTask::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Tasks';

    protected static ?string $slug = 'tasks';

    public static ?Project $project = null;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('project_id')
                    ->relationship('project', 'title')
                    ->live()
                    ->afterStateUpdated(function ($state) {
                        self::$project = Project::find($state);
                    })
                    ->required(),

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
                    ->hidden(fn($get) => empty($get('project_id')))
                    ->options(function ($get) {
                        $project = self::$project;

                        if ($project && $project->boards) {
                            return array_combine($project->boards, $project->boards);
                        }

                        return array_combine(Project::DEFAULT_BOARDS, Project::DEFAULT_BOARDS);
                    }),

                Forms\Components\Select::make('priority')
                    ->hidden(fn($get) => empty($get('project_id')))
                    ->options(function ($get) {
                        $project = self::$project;

                        if ($project && $project->priorities) {
                            return array_combine($project->priorities, $project->priorities);
                        }

                        return array_combine(Project::DEFAULT_PRIORITIES, Project::DEFAULT_PRIORITIES);
                    }),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('status')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('due_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('milestone.title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index'  => Pages\ListProjectTasks::route('/'),
            'create' => Pages\CreateProjectTask::route('/create'),
            'edit'   => Pages\EditProjectTask::route('/{record}/edit'),
        ];
    }
}
