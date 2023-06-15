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

        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string('name', 60);
            $table->string('address', 150);
            $table->json('location');
            $table->json('opening_hours');
            $table->text('info')->nullable();
            $table->json('images')->nullable();
            $table->unsignedInteger('sort');
            $table->boolean('is_active')->default(1);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
