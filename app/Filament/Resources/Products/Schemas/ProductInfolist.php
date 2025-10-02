<?php

namespace App\Filament\Resources\Products\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class ProductInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Section::make(__('Product Information'))
                ->schema([
                    TextEntry::make('sku')
                        ->label('SKU')
                        ->size(TextSize::Small),

                    TextEntry::make('name')
                        ->label('Name')
                        ->size(TextSize::Small),

                    TextEntry::make('description')
                        ->label('Description')
                        ->size(TextSize::Small)
                        ->wrap(),

                    TextEntry::make('category.name')
                        ->label('Category')
                        ->size(TextSize::Small),

                    TextEntry::make('brand.name')
                        ->label('Brand')
                        ->size(TextSize::Small),

                    TextEntry::make('unit.name')
                        ->label('Unit')
                        ->size(TextSize::Small),

                    TextEntry::make('unit_price')
                        ->label('Unit Price')
                        ->money('usd')
                        ->size(TextSize::Small),

                    TextEntry::make('is_active')
                        ->label('Active')
                        ->badge(fn ($record) => $record->is_active ? 'Active' : 'Inactive')
                        ->color(fn ($record) => $record->is_active ? 'success' : 'danger'),

                    TextEntry::make('created_at')
                        ->label('Created At')
                        ->dateTime()
                        ->size(TextSize::Small),

                    TextEntry::make('updated_at')
                        ->label('Updated At')
                        ->dateTime()
                        ->size(TextSize::Medium),
                ])
                ->columns(2)
                ->columnSpanFull(),
            ]);
    }
}
