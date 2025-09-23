<?php

namespace App\Filament\Resources\Units\Pages;

use App\Filament\Resources\Units\UnitResource;
//use App\Utilities\Traits\CustomRedirectUtil;
use Filament\Resources\Pages\CreateRecord;

class CreateUnit extends CreateRecord
{
//    use CustomRedirectUtil;
    protected static string $resource = UnitResource::class;
}
