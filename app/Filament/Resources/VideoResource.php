<?php

namespace App\Filament\Resources;

use App\Filament\Filters\DateRangeFilter;
use App\Filament\Resources\VideoResource\Pages;
use App\Models\Video;
use Filament\{Tables};
use Filament\Forms\Components\Card;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Resources\{Form, Resource, Table};
use Filament\Tables\Filters\SelectFilter;

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

                    FileUpload::make('desktop_path')
                        ->required()
                        ->placeholder('Desktop Path')
                        ->disk('videos')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    FileUpload::make('desktop_thumbnail')
                        ->rules(['file'])
                        ->nullable()
                        ->image()
                        ->placeholder('Desktop Thumbnail')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    FileUpload::make('mobile_path')
                        ->required()
                        ->disk('videos')
                        ->placeholder('Mobile Path')
                        ->columnSpan([
                            'default' => 12,
                            'md' => 12,
                            'lg' => 12,
                        ]),

                    FileUpload::make('mobile_thumbnail')
                        ->rules(['file'])
                        ->nullable()
                        ->image()
                        ->placeholder('Mobile Thumbnail')
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
                Tables\Columns\TextColumn::make('name')
                    ->toggleable()
                    ->searchable(true, null, true)
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
            ]);
    }

    public static function getRelations(): array
    {
        return [
            VideoResource\RelationManagers\VideosRelationManager::class,
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
