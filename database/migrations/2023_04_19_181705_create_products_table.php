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

        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->index();
            $table->string('slug', 150);
            $table->unsignedInteger('category_id')->nullable();
            $table->foreign('category_id')->references('id')->on('categories')->onUpdate('cascade')->onDelete('set null');
            $table->string('sku');
            $table->unsignedInteger('brand_id')->nullable();
            $table->foreign('brand_id')->references('id')->on('brands')->onUpdate('cascade')->onDelete('set null');
            $table->string('short_descr', 200)->nullable();
            $table->decimal('price', 12, 2);
            $table->unsignedTinyInteger('discount_prc')->unsigned()->nullable();
            $table->decimal('final_price', 12, 2);
            $table->decimal('rating', 4, 2)->nullable();
            $table->integer('vote_num')->unsigned()->nullable();
            $table->json('images')->nullable();
            $table->text('description');
            $table->boolean('is_active')->default(1);
            $table->unsignedInteger('promo_id')->nullable();
            $table->foreign('promo_id')->references('id')->on('promos')->onUpdate('cascade')->onDelete('set null');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
