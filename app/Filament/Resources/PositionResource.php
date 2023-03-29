<?php

namespace App\Filament\Resources;

use App\Models\Position;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\TextInput;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\PositionResource\Pages;

class PositionResource extends Resource
{
    protected static ?string $model = Position::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'type';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    TextInput::make('x')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('X')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('y')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('Y')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('zindex')
                        ->rules(['numeric'])
                        ->required()
                        ->numeric()
                        ->placeholder('Zindex')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('type')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Type')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),
                ]),
            ]),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->poll('60s')
            ->columns([
                Tables\Columns\TextColumn::make('x')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('y')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('zindex')
                    ->toggleable()
                    ->searchable(true, null, true),
                Tables\Columns\TextColumn::make('type')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
            ])
            ->filters([DateRangeFilter::make('created_at')]);
    }

    public static function getRelations(): array
    {
        return [
            PositionResource\RelationManagers\InteractsRelationManager::class,
            PositionResource\RelationManagers\VideosRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPositions::route('/'),
            'create' => Pages\CreatePosition::route('/create'),
            'view' => Pages\ViewPosition::route('/{record}'),
            'edit' => Pages\EditPosition::route('/{record}/edit'),
        ];
    }
}
