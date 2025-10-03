<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ProductForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('sku')
                    ->default(fn() => (string) \Illuminate\Support\Str::uuid())
                    ->unique(ignoreRecord: true),

                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                Textarea::make('description')
                    ->rows(3),

                Select::make('category_id')
                    ->relationship('category', 'name')
                    ->preload()
                    ->searchable(),

                Select::make('brand_id')
                    ->relationship('brand', 'name')
                    ->searchable()
                    ->preload()
                    ->optionsLimit(5) // show at least 5 items before search
                    ->createOptionForm([ // mini create form inside the dropdown
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),

                Select::make('unit_id')
                    ->relationship('unit', 'name')
                    ->searchable()
                    ->required()
                    ->preload()
                    ->optionsLimit(5) // show at least 5 items before search
                    ->createOptionForm([ // mini create form inside the dropdown
                        TextInput::make('name')
                            ->required()
                            ->maxLength(255),
                    ]),


                TextInput::make('unit_price')
                    ->numeric()
                    ->prefix('$')
                    ->required(),

                Toggle::make('is_active')
                    ->label('Active')
                    ->default(true),
            ]);
    }
}
