<?php

namespace App\Filament\Resources;

use App\Filament\Resources\LabelProjectResource\Pages;
use App\Models\LabelProject;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class LabelProjectResource extends Resource
{
    protected static ?string $model = LabelProject::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $label = 'Label';

    protected static ?string $navigationParentItem = 'Projects';

    protected static ?string $slug = 'project-labels';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->columnSpan(fn($context) => $context === 'create' ? 2 : 1),
                Forms\Components\TextInput::make('slug')
                    ->hidden(fn($context) => $context === 'create')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageLabelProjects::route('/'),
        ];
    }
}
