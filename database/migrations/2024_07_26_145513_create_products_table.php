<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->string('barcode');
            $table->string('product_image')->nullable();
            $table->integer('garage_id');
            $table->date('buy_date')->nullable();
            $table->date('expire_date')->nullable();
            $table->decimal('buying_price', 15, 2);
            $table->decimal('selling_price', 15, 2);
            $table->integer('qty_store')->nullable();
            $table->integer('category_id');
            $table->integer('supplier_id');
            $table->integer('units_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
