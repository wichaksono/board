<?php

namespace App\Filament\Resources;

use App\Filament\Forms\Components\ColorInputField;
use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255)
                    ->columnSpanFull(),

                Forms\Components\Select::make('customer_id')
                    ->label('Customer')
                    ->relationship('customer', 'name')
                    ->nullable()
                    ->searchable()
                    ->preload(),

                Forms\Components\Select::make('pm_id')
                    ->label('Project Manager')
                    ->relationship('user', 'name')
                    ->required()
                    ->searchable()
                    ->preload(),

                Forms\Components\RichEditor::make('description')
                    ->toolbarButtons([
                        'attachFiles',
                        'blockquote',
                        'bold',
                        'bulletList',
                        'codeBlock',
                        'h2',
                        'h3',
                        'italic',
                        'link',
                        'orderedList',
                        'redo',
                        'strike',
                        'underline',
                        'undo',
                    ])
                    ->disableGrammarly()
                    ->columnSpanFull(),
                Forms\Components\FileUpload::make('attachments')
                    ->multiple()
                    ->reorderable()
                    ->appendFiles()
                    ->downloadable()
                    ->directory('projects/' . date('Y/m'))
                    ->columnSpanFull(),

                Forms\Components\Section::make('Board')
                    ->hidden(fn($context) => $context === 'create')
                    ->schema([
                        Forms\Components\Repeater::make('boards')
                            ->required()
                            ->hiddenLabel()
                            ->simple(Forms\Components\TextInput::make('board')
                                ->required()
                                ->maxLength(255))
                            ->reorderable()
                            ->addActionLabel('Add Board'),
                    ])->columnSpan(1),

                Forms\Components\Section::make('Priorities')
                    ->hidden(fn($context) => $context === 'create')
                    ->schema([
                        Forms\Components\Repeater::make('priorities')
                            ->hiddenLabel()
                            ->required()
                            ->simple(Forms\Components\TextInput::make('priority')
                                ->required()
                                ->maxLength(255))
                            ->reorderable()
                            ->addActionLabel('Add Priority'),
                    ])->columnSpan(1),

                Forms\Components\Section::make('Milestones')
                    ->schema([
                        Forms\Components\Repeater::make('milestones')
                            ->relationship()
                            ->hiddenLabel()
                            ->columns()
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->required()
                                    ->live(onBlur: true)
                                    ->maxLength(255)
                                    ->columnSpanFull(),
                                Forms\Components\Datepicker::make('start_date')
                                    ->required(),

                                Forms\Components\Datepicker::make('due_date')
                                    ->required(),

                                Forms\Components\RichEditor::make('description')
                                    ->toolbarButtons([
                                        'attachFiles',
                                        'blockquote',
                                        'bold',
                                        'bulletList',
                                        'codeBlock',
                                        'h2',
                                        'h3',
                                        'italic',
                                        'link',
                                        'orderedList',
                                        'redo',
                                        'strike',
                                        'underline',
                                        'undo',
                                    ])
                                    ->disableGrammarly()
                                    ->columnSpanFull(),
                            ])
                            ->addActionLabel('Add Milestone')
                            ->reorderable()
                            ->itemLabel(fn(array $state): ?string => $state['title'] ?? null)
                            ->columnSpanFull(),
                    ])
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('projectManager.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('customer.name')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Creator')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
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
                Tables\Actions\ViewAction::make(),
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                ]),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->deferLoading()
           /* ->recordClasses(fn (Model $record) => match ($record->status) {
                'draft' => 'opacity-30',
                'reviewing' => 'border-s-2 border-orange-600 dark:border-orange-300',
                'published' => 'border-s-2 border-green-600 dark:border-green-300',
                default => null,
            })*/;
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
            'index'  => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit'   => Pages\EditProject::route('/{record}/edit'),
            'view'   => Pages\ViewProject::route('/{record}'),
            'board'  => Pages\ProjectBoard::route('/{record}/board'),
        ];
    }
}
