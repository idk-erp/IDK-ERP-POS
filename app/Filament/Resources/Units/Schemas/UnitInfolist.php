<?php

namespace App\Filament\Resources\Units\Schemas;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Filament\Support\Enums\TextSize;

class UnitInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make(__('Unit Information'))
                    ->schema([
                        TextEntry::make('name')
                            ->label('Name')
                            ->size(TextSize::Small),
                        TextEntry::make('short_name')
                            ->label('Short Name')
                            ->size(TextSize::Small),
                        TextEntry::make('description')
                            ->label('Description')
                            ->size(TextSize::Small)
                            ->wrap(),
                        TextEntry::make('created_at')
                            ->label('Created At')
                            ->size(TextSize::Small)
                            ->dateTime(),
                        TextEntry::make('updated_at')
                            ->label('Updated At')
                            ->size(TextSize::Medium)
                            ->dateTime(),
                    ])
                    ->columns(2)
                    ->columnSpanFull(),
            ]);
    }
}
