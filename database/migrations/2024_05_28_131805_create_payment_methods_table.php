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
        Schema::create('payment_methods', function (Blueprint $table) {

            $table->id();
            $table->Integer('user_id')->nullable();
            $table->integer('stripe_id')->nullable();
            $table->integer('card_number')->nullable();
            $table->String('expiry_date')->nullable();
            $table->String('cvc')->nullable();
            $table->integer('payment_method')->default(0)->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_methods');
    }
};
