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
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->unsignedInteger('supplier_id');
            $table->foreignId('location_id')->constrained('locations')->onDelete('restrict');


            $table->string('reference')->unique();
            $table->string('status')->default('draft')->comment('Status of the purchase (e.g., pending, received, ordered)');
            $table->string('payment_status')->default('due')->comment('Payment status (e.g., due, partial, paid)');
            $table->timestamp('purchase_date')->useCurrent();

            $table->decimal('total_amount', 10, 4)->default(0);
            $table->string('discount_type')->nullable()->comment('fixed or percentage');
            $table->decimal('discount_amount', 10, 4)->default(0);
            $table->decimal('shipping_cost', 10, 4)->default(0);
            $table->decimal('grand_total', 10, 4)
                ->storedAs('total_amount - discount_amount + shipping_cost');
            $table->decimal('paid_amount', 10, 4)->default(0);
            $table->decimal('balance_amount', 10, 4)
                ->storedAs('(total_amount - discount_amount + shipping_cost) - paid_amount');

            $table->string('document')->nullable()->comment('File path or name of the attached document');
            $table->text('notes')->nullable();

            $table->foreignId('created_by')->constrained('users')->onDelete('restrict');
            $table->foreignId('updated_by')->nullable()->constrained('users')->onDelete('restrict');
            $table->foreignId('deleted_by')->nullable()->constrained('users')->onDelete('restrict');

            $table->timestamps();
            $table->softDeletes();

            $table->index('status');
            $table->index('payment_status');
            $table->index('purchase_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
