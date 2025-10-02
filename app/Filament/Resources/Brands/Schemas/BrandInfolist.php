<?php

namespace App\Filament\Resources\Brands\Schemas;

use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;
use Filament\Schemas\Components\Section;
use Filament\Infolists\Components\TextEntry;

class BrandInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
            Section::make(__('Brand Information'))
                ->schema([
                    TextEntry::make('name')
                        ->label('Name')
                        ->size(TextSize::Small),
                ])
                ->columns(2)
                ->columnSpanFull(),
            ]);
    }
}
