<?php

namespace App\Filament\Resources\Purchases\Schemas;

use App\Enums\PaymentStatus;
use App\Enums\PurchaseStatus;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class PurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                            Select::make('supplier_id')
                                    ->label('Supplier')
                                    ->native(false)
                                    ->required(),
                            Select::make('location_id')
                                    ->label('Location')
                                    ->relationship('location', 'name')
                                    ->native(false)
                                    ->preload()->searchable()
                                    ->required(),
                            Select::make('status')
                                ->options(PurchaseStatus::class)
                                ->default(PurchaseStatus::Draft)
                                ->required(),

                            Select::make('payment_status')
                                    ->options(PaymentStatus::class)
                                    ->default(PaymentStatus::Due)
                                    ->native(false)
                                    ->required(),
                            DateTimePicker::make('purchase_date')
                                ->label('Purchase Date')
                                ->native(false)
                                ->default(now())
                                ->required(),
                        ])->columns(2),

                Repeater::make('items')
                    ->relationship('items')
                    ->table([
                        TableColumn::make('Product'),
                        TableColumn::make('Quantity')
                            ->width(200),
                        TableColumn::make('Unit')
                            ->width(200),
                        TableColumn::make('Unit Price')
                            ->width(200),
                    ])
                    ->schema([
                        Select::make('product_id')
                            ->label('Product')
                            ->relationship('product', 'name')
                            ->preload()
                            ->searchable(),

                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->default(1)
                            ->live(onBlur: true)
                            ->debounce(500)
                            ->reactive()
                            ->required(),
                        Select::make('uom_id')
                            ->native(false)
                            ->default(1)
                            ->preload()
                            ->relationship('unit', 'name'),
                        TextInput::make('unit_price')
                            ->numeric()
                            ->required(),

                        Hidden::make('sub_total_price')
                            ->required(),
                    ])
                    ->live()
                    ->defaultItems(1)
                    ->hiddenLabel()
                    ->required(),

                TextInput::make('total_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('discount_type'),
                TextInput::make('discount_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('shipping_cost')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('grand_total')
                    ->numeric(),
                TextInput::make('paid_amount')
                    ->required()
                    ->numeric()
                    ->default(0.0),
                TextInput::make('balance_amount')
                    ->numeric(),
                TextInput::make('document'),
                Textarea::make('notes')
                    ->columnSpanFull(),
            ])->columns(1);
    }
}
