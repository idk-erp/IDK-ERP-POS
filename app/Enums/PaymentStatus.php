<?php


namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PaymentStatus: string implements HasColor, HasIcon, HasLabel
{
    case Due = 'due';
    case Partial = 'partial';
    case Paid = 'paid';

    public function getLabel(): string
    {
        return match ($this) {
            self::Due => 'Due',
            self::Partial => 'Partial',
            self::Paid => 'Paid',
        };
    }

    public function getColor(): string
    {
        return match ($this) {
            self::Due => 'danger',
            self::Partial => 'warning',
            self::Paid => 'success',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Due => 'heroicon-o-exclamation-circle',
            self::Partial => 'heroicon-o-currency-dollar',
            self::Paid => 'heroicon-o-check-circle',
        };
    }
}
