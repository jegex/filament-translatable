<?php

namespace Jegex\FilamentTranslatable\Tests\Fixtures\Resources;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Jegex\FilamentTranslatable\Enums\TranslationMode;
use Jegex\FilamentTranslatable\Forms\Component\Translations;
use Jegex\FilamentTranslatable\Tests\Fixtures\Models\AstrotomicProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\CreateAstrotomicProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\EditAstrotomicProduct;
use Jegex\FilamentTranslatable\Tests\Fixtures\Resources\Pages\ListAstrotomicProducts;

class AstrotomicProductResource extends Resource
{
    protected static ?string $model = AstrotomicProduct::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('price')
                    ->numeric()
                    ->prefix('$'),

                Translations::make('translations')
                    ->translationMode(TranslationMode::Astrotomic)
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
            'index' => ListAstrotomicProducts::route('/'),
            'create' => CreateAstrotomicProduct::route('/create'),
            'edit' => EditAstrotomicProduct::route('/{record}/edit'),
        ];
    }
}
