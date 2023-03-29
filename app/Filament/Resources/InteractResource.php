<?php

namespace App\Filament\Resources;

use App\Models\Interact;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\InteractResource\Pages;

class InteractResource extends Resource
{
    protected static ?string $model = Interact::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'content';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    Select::make('video_id')
                        ->rules(['exists:videos,id'])
                        ->required()
                        ->relationship('video', 'path')
                        ->searchable()
                        ->placeholder('Video')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('link_to')
                        ->rules(['exists:videos,id'])
                        ->required()
                        ->relationship('interactWith', 'path')
                        ->searchable()
                        ->placeholder('Interact With')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    RichEditor::make('content')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Content')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    Select::make('position_id')
                        ->rules(['exists:positions,id'])
                        ->required()
                        ->relationship('position', 'type')
                        ->searchable()
                        ->placeholder('Position')
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
                Tables\Columns\TextColumn::make('video.path')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('interactWith.path')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('content')
                    ->toggleable()
                    ->searchable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('position.type')
                    ->toggleable()
                    ->limit(50),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('video_id')
                    ->relationship('video', 'path')
                    ->indicator('Video')
                    ->multiple()
                    ->label('Video'),

                SelectFilter::make('link_to')
                    ->relationship('interactWith', 'path')
                    ->indicator('Video')
                    ->multiple()
                    ->label('Video'),

                SelectFilter::make('position_id')
                    ->relationship('position', 'type')
                    ->indicator('Position')
                    ->multiple()
                    ->label('Position'),
            ]);
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListInteracts::route('/'),
            'create' => Pages\CreateInteract::route('/create'),
            'view' => Pages\ViewInteract::route('/{record}'),
            'edit' => Pages\EditInteract::route('/{record}/edit'),
        ];
    }
}
