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
        Schema::disableForeignKeyConstraints();

        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->enum('status', ['new', 'accepted', 'sent', 'completed', 'cancelled'])->default('new');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->string('name');
            $table->string('phone', 15);
            $table->enum('shipping_m', ['delivery', 'self'])->default('delivery');
            $table->enum('payment_m', ['online', 'card', 'cash'])->default('online');
            $table->string('address', 150);
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->decimal('total', 10, 2);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
