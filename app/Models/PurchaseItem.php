<?php

namespace App\Models;

use App\Traits\Blamable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseItem extends Model
{
    use SoftDeletes;
    use Blamable;

    protected $fillable = [
        'purchase_id',
        'product_id',
        'quantity',
        'received_quantity',
        'unit_id',
        'unit_price',
        'expiry_date',
        'lot_serial_number',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'quantity' => 'decimal:4',
        'received_quantity' => 'decimal:4',
        'unit_price' => 'decimal:4',
        'expiry_date' => 'date',
    ];


    public function purchase()
    {
        return $this->belongsTo(Purchase::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }
}
