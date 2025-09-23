<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchase_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->constrained('purchases', 'id');
            $table->foreignId('product_id')->constrained('products', 'id');
            $table->decimal('quantity', 10, 4)->default(0);
            $table->decimal('received_quantity', 10, 4)->default(0);
            $table->foreignId('unit_id')->constrained('units', 'id');
            $table->decimal('unit_price', 10, 4);
            $table->date('expiry_date')->nullable();
            $table->string('lot_serial_number')->nullable();
            $table->decimal('sub_total_price', 10, 4)
                ->storedAs('(unit_price * quantity)');

            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();

            $table->index(['purchase_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_items');
    }
};
