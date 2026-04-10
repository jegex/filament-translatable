<?php

namespace Jegex\FilamentTranslatable\Tests\Fixtures\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Jegex\FilamentTranslatable\Forms\Component\Translations;
use Jegex\FilamentTranslatable\Tests\Fixtures\Models\SpatieProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\CreateSpatieProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\EditSpatieProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\ListSpatieProducts;

class SpatieProductResource extends Resource
{
    protected static ?string $model = SpatieProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),

                Translations::make('translations')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255),

                        Forms\Components\Textarea::make('description')
                            ->maxLength(65535)
                            ->columnSpanFull(),
                    ])
                    ->columns(1),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('price')
                    ->money()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
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

    public static function getPages(): array
    {
        return [
            'index' => ListSpatieProducts::route('/'),
            'create' => CreateSpatieProduct::route('/create'),
            'edit' => EditSpatieProduct::route('/{record}/edit'),
        ];
    }
}
