<?php

namespace App\Filament\Resources\Categories\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class CategoryInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Category Information'))
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
