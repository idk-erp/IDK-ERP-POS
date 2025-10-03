<?php

namespace App\Filament\Resources\Purchases\Schemas;

use App\Enums\PaymentStatus;
use App\Enums\PurchaseStatus;
use App\Models\Product;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Repeater\TableColumn;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class PurchaseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('Invoice')
                    ->columns(2)
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
                        TableColumn::make('Total')
                            ->width(200),
                    ])
                    ->addActionLabel('Add Product')
                    ->schema([
                        Select::make('product_id')
                            ->label('Product')
                            ->relationship('product', 'name')
                            ->preload()
                            ->afterStateUpdated(function ($state, Get $get, Set $set) {
                                if (!$state) {
                                    $set('uom_id', null);
                                    $set('quantity', null);
                                    $set('unit_price', null);
                                    return;
                                }

                                $product = Product::find($state);

                                $unitPrice = $product->unit_price ?? 0;

                                $set('uom_id', $product->unit->id);
                                $set('quantity', 1);
                                $set('unit_price', $unitPrice);
                                $set('sub_total_price', $unitPrice * 1);

                                $totalAmount = $get('../../total_amount');
                                $grandTotal = $get('../../grand_total');

                                $set('../../total_amount', $totalAmount + $unitPrice);
                                $set('../../grand_total', $grandTotal + $unitPrice);

                            })
                            ->searchable(),

                        TextInput::make('quantity')
                            ->label('Quantity')
                            ->numeric()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $set('sub_total_price', $state * $get('unit_price'));
                            })
                            ->required(),
                        Select::make('uom_id')
                            ->native(false)
                            ->disabled()
                            ->dehydrated()
                            ->relationship('unit', 'name'),
                        TextInput::make('unit_price')
                            ->numeric()
                            ->afterStateUpdated(function ($state, callable $set, $get) {
                                $set('sub_total_price', $state * $get('quantity'));
                            })
                            ->required(),

                        TextInput::make('sub_total_price')
                            ->numeric()
                            ->disabled()
                            ->dehydrated()
                            ->required(),
                    ])
                    ->live(onBlur: true)
                    ->afterStateUpdated(fn (Get $get, Set $set) => self::updateTotals($get, $set))
                    ->defaultItems(1)
                    ->hiddenLabel()
                    ->required(),

                Section::make('Amount Details')
                    ->columns(2) // Two columns
                    ->schema([
                        Hidden::make('total_amount')
                            ->required()
                            ->default(0.0),

                        Hidden::make('discount_amount')
                            ->default(0.0),

                        Hidden::make('shipping_cost')
                            ->default(0.0),

                        TextInput::make('grand_total')
                            ->label('Total Amount')
                            ->columnSpanFull()
                            ->numeric(),

                        TextInput::make('balance_amount')
                            ->numeric(),

                        TextInput::make('paid_amount')
                            ->required()
                            ->numeric()
                            ->default(0.0)
                            ->afterStateUpdated(function ($state, Set $set, Get $get) {
                                $grandTotal = $get('grand_total') ?? 0;
                                $paidAmount = $state ?? 0;

                                $set('balance_amount', $grandTotal - $paidAmount);
                            }),
        ]),

//                TextInput::make('discount_type'),
//                TextInput::make('document'),
//                Textarea::make('notes')
//                    ->columnSpanFull(),
            ])->columns(1);
    }

    public static function updateTotals(Get $get, Set $set): void
    {
        $items = $get('items') ?? [];

        $subtotal = 0;

        foreach ($items as $item) {
            $subtotal += (float) ($item['quantity'] ?? 0) * ($item['unit_price'] ?? 0);
        }

        $set('total_amount', $subtotal);
        $set('grand_total', $subtotal);
        $set('balance_amount', $subtotal);
    }
}
