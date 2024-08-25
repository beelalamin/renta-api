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
        Schema::create('bookings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('customer_id')->constrained('customers');
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->foreignId('payment_id')->constrained('payments');
            $table->foreignId('location_id')->constrained('locations');
            $table->enum('type', ['rental', 'subscription']);
            $table->enum('protection', ['standard', 'advance'])->nullable();
            $table->decimal('total_amount', 10, 2);
            $table->enum('status', ['processing', 'delivered', 'cancelled']);
            $table->string('mileage')->nullable();
            $table->string('infant_seat')->nullable();
            $table->boolean('additional_driver')->default(false);
            $table->timestamp('pickup_at');
            $table->timestamp('return_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
