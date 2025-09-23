<?php

namespace App\Models;

use App\Enums\PaymentStatus;
use App\Enums\PurchaseStatus;
use App\Traits\Blamable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Purchase extends Model
{
    use SoftDeletes;
    use Blamable;

    protected $fillable = [
        'supplier_id',
        'location_id',
        'reference',
        'status',
        'payment_status',
        'purchase_date',
        'total_amount',
        'discount_type',
        'discount_amount',
        'shipping_cost',
        'paid_amount',
        'document',
        'notes',
        'created_by',
        'updated_by',
        'deleted_by',
    ];

    protected $casts = [
        'status' => PurchaseStatus::class,
        'payment_status' => PaymentStatus::class,
        'purchase_date' => 'datetime',
        'total_amount' => 'decimal:4',
        'discount_amount' => 'decimal:4',
        'shipping_cost' => 'decimal:4',
        'paid_amount' => 'decimal:4',
    ];

//
//    public function supplier()
//    {
//        return $this->belongsTo(Supplier::class);
//    }

    public function location()
    {
        return $this->belongsTo(Location::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseItem::class);
    }

}
