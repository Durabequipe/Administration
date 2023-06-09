<?php

namespace App\Filament\Resources\ProjectResource\RelationManagers;

use App\Models\Interaction;
use Filament\Forms;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\{Form, Table};
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Filters\MultiSelectFilter;
use Illuminate\Database\Eloquent\Builder;

class VideosRelationManager extends RelationManager
{
    protected static string $relationship = 'videos';

    protected static ?string $recordTitleAttribute = 'desktop_path';

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('project.name')->limit(50),
                Tables\Columns\TextColumn::make('name')->limit(50),
                Tables\Columns\TextColumn::make('interaction.delay')
                    ->label('Delay'),
                Tables\Columns\TextColumn::make('interaction.position')
                    ->label('Position'),
                Tables\Columns\ImageColumn::make(
                    'desktop_thumbnail'
                )->rounded(),
                Tables\Columns\IconColumn::make('is_main'),
            ])
            ->filters([
                Tables\Filters\Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from'),
                        Forms\Components\DatePicker::make('created_until'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn(
                                    Builder $query,
                                            $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '>=',
                                    $date
                                )
                            )
                            ->when(
                                $data['created_until'],
                                fn(
                                    Builder $query,
                                            $date
                                ): Builder => $query->whereDate(
                                    'created_at',
                                    '<=',
                                    $date
                                )
                            );
                    }),

                MultiSelectFilter::make('project_id')->relationship(
                    'project',
                    'name'
                ),
            ])
            ->headerActions([Tables\Actions\CreateAction::make()])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([Tables\Actions\DeleteBulkAction::make()]);
    }

    public static function form(Form $form): Form
    {
        return $form->schema([
            Grid::make(['default' => 0])->schema([
                TextInput::make('name')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Name')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),
                FileUpload::make('desktop_path')
                    ->required()
                    ->placeholder('Desktop video path')
                    ->disk('videos')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                FileUpload::make('desktop_thumbnail')
                    ->rules(['image', 'max:1024'])
                    ->image()
                    ->placeholder('Desktop Thumbnail')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                FileUpload::make('mobile_path')
                    ->placeholder('Mobile video path')
                    ->disk('videos')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                FileUpload::make('mobile_thumbnail')
                    ->rules(['image', 'max:1024'])
                    ->image()
                    ->placeholder('Mobile Thumbnail')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Toggle::make('is_main')
                    ->rules(['boolean'])
                    ->default('false')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                TextInput::make('interaction_title')
                    ->label('Interaction Title')
                    ->rules(['max:255', 'string'])
                    ->placeholder('Interaction Title')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ]),

                Forms\Components\Select::make('interaction_id')
                    ->relationship('interaction', 'id')
                    ->placeholder('Select an interaction')
                    ->columnSpan([
                        'default' => 12,
                        'md' => 12,
                        'lg' => 12,
                    ])
                    ->getOptionLabelFromRecordUsing(function (Interaction $record) {
                        return $record->delay . ' sec. - ' . $record->position;
                    })
                    ->createOptionForm([
                        Forms\Components\TextInput::make('delay')
                            ->numeric()
                            ->required(),
                        Forms\Components\Select::make('position')
                            ->options([
                                'bottom' => 'Bottom',
                                'full' => 'Full',
                            ])
                            ->required(),

                        TextInput::make('title')
                            ->label('Title')
                            ->rules(['max:255', 'string'])
                            ->placeholder('Title')
                            ->columnSpan([
                                'default' => 12,
                                'md' => 12,
                                'lg' => 12,
                            ]),
                    ])
            ]),
        ]);
    }
}
