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
        Schema::create('sells', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->string('invoice_no')->nullable();
            $table->string('reference')->nullable();
            $table->date('sell_date')->nullable();
            $table->decimal('subtotal',15,2)->nullable();
            $table->decimal('discount',15,2)->nullable();
            $table->decimal('tax',15,2)->nullable();
            $table->decimal('total_payment',15,2)->nullable();
            $table->text('note');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sells');
    }
};
