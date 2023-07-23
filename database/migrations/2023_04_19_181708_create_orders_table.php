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
            $table->enum('status', ['new', 'accepted', 'ready', 'sent', 'completed', 'cancelled'])->default('new');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('set null');
            $table->string('name');
            $table->string('phone', 25);
            $table->string('email', 150)->nullable();
            $table->enum('delivery_type', ['delivery', 'self'])->default('delivery');
            $table->enum('payment_method', ['online', 'card', 'cash', 'shop'])->default('online');
            $table->boolean('payment_status')->default(0);
            $table->string('delivery_address', 150);
            $table->unsignedBigInteger('shop_id')->nullable();
            $table->foreign('shop_id')->references('id')->on('shops')->onUpdate('cascade')->onDelete('no action');
            $table->decimal('items_cost', 12, 2);
            $table->decimal('shipping_cost', 10, 2)->nullable();
            $table->decimal('total_cost', 12, 2);
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
