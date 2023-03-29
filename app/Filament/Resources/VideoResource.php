<?php

namespace App\Filament\Resources;

use App\Models\Video;
use Filament\{Tables, Forms};
use Filament\Resources\{Form, Table, Resource};
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Filters\SelectFilter;
use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\VideoResource\Pages;

class VideoResource extends Resource
{
    protected static ?string $model = Video::class;

    protected static ?string $navigationIcon = 'heroicon-o-collection';

    protected static ?string $recordTitleAttribute = 'path';

    public static function form(Form $form): Form
    {
        return $form->schema([
            Card::make()->schema([
                Grid::make(['default' => 0])->schema([
                    Select::make('project_id')
                        ->rules(['exists:projects,id'])
                        ->required()
                        ->relationship('project', 'name')
                        ->searchable()
                        ->placeholder('Project')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    TextInput::make('path')
                        ->rules(['max:255', 'string'])
                        ->required()
                        ->placeholder('Path')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    FileUpload::make('thumbnail')
                        ->rules(['file'])
                        ->nullable()
                        ->image()
                        ->placeholder('Thumbnail')
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

                    Toggle::make('is_main')
                        ->rules(['boolean'])
                        ->required()
                        ->default('false')
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
                Tables\Columns\TextColumn::make('project.name')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\TextColumn::make('path')
                    ->toggleable()
                    ->searchable(true, null, true)
                    ->limit(50),
                Tables\Columns\ImageColumn::make('thumbnail')
                    ->toggleable()
                    ->circular(),
                Tables\Columns\TextColumn::make('position.type')
                    ->toggleable()
                    ->limit(50),
                Tables\Columns\IconColumn::make('is_main')
                    ->toggleable()
                    ->boolean(),
            ])
            ->filters([
                DateRangeFilter::make('created_at'),

                SelectFilter::make('project_id')
                    ->relationship('project', 'name')
                    ->indicator('Project')
                    ->multiple()
                    ->label('Project'),

                SelectFilter::make('position_id')
                    ->relationship('position', 'type')
                    ->indicator('Position')
                    ->multiple()
                    ->label('Position'),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            VideoResource\RelationManagers\InteractsRelationManager::class,
            VideoResource\RelationManagers\InteractsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListVideos::route('/'),
            'create' => Pages\CreateVideo::route('/create'),
            'view' => Pages\ViewVideo::route('/{record}'),
            'edit' => Pages\EditVideo::route('/{record}/edit'),
        ];
    }
}
