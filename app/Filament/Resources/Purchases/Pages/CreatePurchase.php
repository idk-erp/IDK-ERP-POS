<?php

namespace App\Filament\Resources\Purchases\Pages;

use App\Filament\Resources\Purchases\PurchaseResource;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Enums\Width;

class CreatePurchase extends CreateRecord
{
    protected static string $resource = PurchaseResource::class;

    public function getMaxContentWidth(): Width
    {
        return Width::Full;
    }
}
