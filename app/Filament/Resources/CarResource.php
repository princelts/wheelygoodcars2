<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CarResource\Pages;
use App\Filament\Resources\CarResource\RelationManagers;
use App\Models\Car;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CarResource extends Resource
{
    protected static ?string $model = Car::class;
    protected static ?string $navigationGroup = 'Management';
    protected static ?string $navigationIcon = 'heroicon-o-truck';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('license_plate')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('brand')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('model')
                    ->required()
                    ->maxLength(255),
                
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->required(),
                
                Forms\Components\TextInput::make('mileage')
                    ->numeric()
                    ->required(),
                
                Forms\Components\TextInput::make('color')
                    ->maxLength(255)
                    ->nullable(),
                
                Forms\Components\DatePicker::make('sold_at')
                    ->nullable(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            Tables\Columns\TextColumn::make('license_plate')
                ->label('License Plate')
                ->badge(fn ($record) => $record->license_plate)
                ->searchable(),

            Tables\Columns\TextColumn::make('brand')
                ->sortable(),

            Tables\Columns\TextColumn::make('model')
                ->sortable(),

            Tables\Columns\TextColumn::make('price')
                ->sortable()
                ->money('EUR'), // Change currency if needed
            
            Tables\Columns\TextColumn::make('mileage')
                ->formatStateUsing(fn (string $state): string => "{$state} km")
                ->sortable(),

            Tables\Columns\TextColumn::make('color')
                ->sortable(),

            Tables\Columns\TextColumn::make('sold_at')
                ->dateTime()
                ->placeholder('-')
                ->sortable(),
        ])
            ->filters([
                Tables\Filters\SelectFilter::make('brand')
                    ->options(Car::pluck('brand', 'brand')->toArray()),
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
            'index' => Pages\ListCars::route('/'),
            'create' => Pages\CreateCar::route('/create'),
            'edit' => Pages\EditCar::route('/{record}/edit'),
        ];
    }
}
