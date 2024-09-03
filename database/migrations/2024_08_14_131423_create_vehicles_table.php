<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->json('title');
            $table->json('description');
            $table->decimal('price', 10, 2)->nullable();
            $table->foreignId('brand_id')->nullable()->constrained('brands');
            $table->foreignId('thumbnail_id')->nullable()->constrained('media');
            $table->enum('transmission', ['manual', 'automatic'])->nullable();
            $table->enum('fuel_type', ['gasoline', 'hybrid', 'electric'])->nullable();
            $table->string('model')->nullable();
            $table->integer('seating_capacity')->nullable();
            $table->decimal('mileage', 4, 2)->nullable();
            $table->string('vehicle_number');
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_published')->default(false);
            $table->foreignId('created_by')->constrained('users')->nullOnDelete();
            $table->foreignId('updated_by')->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
