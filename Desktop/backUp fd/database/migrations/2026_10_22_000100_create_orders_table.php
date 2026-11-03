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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('checkout_session_id')->unique();
            $table->string('customer_name')->nullable();
            $table->string('customer_whatsapp', 30)->nullable();
            $table->string('customer_email')->nullable();
            $table->unsignedInteger('amount');
            $table->string('currency', 3)->default('brl');
            $table->enum('status', ['pending', 'paid'])->default('pending');
            $table->string('access_token')->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
