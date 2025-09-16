<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Currency extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'full_name',
        'name',
        'symbol',
        'code',
        'active',
        'decimal_places',
        'deleted_by',
        'created_by',
        'updated_by',
    ];
}
