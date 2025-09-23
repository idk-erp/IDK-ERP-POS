<?php
namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;
use Filament\Support\Contracts\HasLabel;

enum PurchaseStatus: string implements HasColor, HasIcon, HasLabel
{
    case Draft = 'draft';
    case Pending = 'pending';
    case Ordered = 'ordered';
    case Received = 'received';
    case Cancelled = 'cancelled';

    public function getLabel(): string
    {
        return match ($this) {
            self::Draft => 'Draft',
            self::Pending => 'Pending',
            self::Ordered => 'Ordered',
            self::Received => 'Received',
            self::Cancelled => 'Cancelled',
        };
    }


    public function getColor(): string
    {
        return match ($this) {
            self::Draft, self::Pending  => 'info',
            self::Ordered => 'warning',
            self::Received => 'success',
            self::Cancelled => 'danger',
        };
    }

    public function getIcon(): string
    {
        return match ($this) {
            self::Draft, self::Pending => 'heroicon-o-document-text',
            self::Ordered => 'heroicon-o-document-check',
            self::Received => 'heroicon-m-truck',
            self::Cancelled => 'heroicon-m-x-circle',
        };
    }
}
