<?php

namespace App\Filament\Resources;

use App\Filament\Resources\TagResource\Pages;
use App\Models\Tag;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class TagResource extends Resource
{
    protected static ?string $model = Tag::class;
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $modelLabel = 'Tag';
    protected static ?string $pluralModelLabel = 'Tags';
    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->label('Naam'),
                
                Forms\Components\Select::make('group')
                    ->options([
                        'brandstof_type' => 'Brandstof Type',
                        'aandrijving' => 'Aandrijving',
                        'transmissie' => 'Transmissie',
                        'carrosserie' => 'Carrosserie',
                        'voertuigklasse' => 'Voertuigklasse',
                        'uitrusting' => 'Uitrusting',
                        'conditie' => 'Conditie',
                        'gebruik' => 'Gebruik',
                    ])
                    ->required()
                    ->label('Groep'),
                
                Forms\Components\ColorPicker::make('color')
                    ->label('Kleur')
                    ->required(),
                
                Forms\Components\Section::make('Statistieken')
                    ->schema([
                        Forms\Components\TextInput::make('used_count')
                            ->numeric()
                            ->label('Totaal gebruikt')
                            ->disabled(),
                        Forms\Components\TextInput::make('used_sold_count')
                            ->numeric()
                            ->label('Verkochte voertuigen')
                            ->disabled(),
                        Forms\Components\TextInput::make('used_unsold_count')
                            ->numeric()
                            ->label('Niet-verkochte voertuigen')
                            ->disabled(),
                    ])->columns(3)
            ]);
    }

public static function table(Table $table): Table
{
    return $table
        ->defaultSort('used_count', 'desc')
        ->columns([
            Tables\Columns\TextColumn::make('name')
                ->searchable()
                ->sortable()
                ->label('Naam'),

            Tables\Columns\TextColumn::make('group')
                ->badge()
                ->formatStateUsing(fn (string $state): string => match ($state) {
                    'brandstof_type' => 'Brandstof',
                    'aandrijving' => 'Aandrijving',
                    'transmissie' => 'Transmissie',
                    'carrosserie' => 'Carrosserie',
                    'voertuigklasse' => 'Klasse',
                    'uitrusting' => 'Uitrusting',
                    'conditie' => 'Conditie',
                    'gebruik' => 'Gebruik',
                    default => $state,
                })
                ->sortable()
                ->label('Groep'),

            Tables\Columns\ColorColumn::make('color')
                ->label('Kleur'),

            Tables\Columns\TextColumn::make('used_count')
                ->numeric()
                ->sortable()
                ->label('Totaal')
                ->tooltip('Totaal aantal keren gebruikt'),

            Tables\Columns\TextColumn::make('used_sold_count')
                ->numeric()
                ->sortable()
                ->label('Verkocht')
                ->tooltip('Aantal keren bij verkochte voertuigen'),
                
            Tables\Columns\TextColumn::make('conversion_rate')
                ->numeric()
                ->suffix('%')
                ->sortable(query: fn (Builder $query, string $direction) => $query->orderByConversionRate($direction))
                ->label('Conversie')
                ->tooltip('Percentage verkochte voertuigen met deze tag')
                ->color(fn (float $state): string => match (true) {
                    $state >= 50 => 'success',
                    $state >= 30 => 'warning',
                    default => 'danger',
                }),
        ])
        ->filters([
            Tables\Filters\SelectFilter::make('group')
                ->options([
                    'brandstof_type' => 'Brandstof Type',
                    'aandrijving' => 'Aandrijving',
                    'transmissie' => 'Transmissie',
                    'carrosserie' => 'Carrosserie',
                    'voertuigklasse' => 'Voertuigklasse',
                    'uitrusting' => 'Uitrusting',
                    'conditie' => 'Conditie',
                    'gebruik' => 'Gebruik',
                ])
                ->label('Filter op groep'),
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


    public static function getRelations(): array
    {
        return [
            // RelationManagers\CarsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListTags::route('/'),
            'create' => Pages\CreateTag::route('/create'),
            'edit' => Pages\EditTag::route('/{record}/edit'),
        ];
    }
}