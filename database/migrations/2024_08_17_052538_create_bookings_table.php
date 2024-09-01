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
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('vehicle_id')->constrained('vehicles');
            $table->enum('protection', ['basic', 'partial', 'full'])->default('basic');
            $table->enum('booking_type', ['rental', 'subscription'])->default('basic');
            $table->enum('status', ['new', 'processing', 'completed', 'cancelled']);
            $table->string('mileage')->nullable();
            $table->string('booking_number');
            $table->integer('infant_seat')->nullable();
            $table->boolean('driver')->default(false);
            $table->boolean('is_active')->default(true);
            $table->longText('note')->nullable();
            $table->foreignId('pickup_location_id')->constrained('locations')->onDelete('cascade');
            $table->foreignId('return_location_id')->constrained('locations')->onDelete('cascade');
            $table->timestamp('pickup_date');
            $table->timestamp('return_date');
            $table->enum('subscription_plan', ['basic', 'premium'])->nullable();
            $table->enum('billing_cycle', ['weekly', 'monthly'])->nullable();
            $table->boolean('auto_renewal')->default(false);
            $table->date('last_notified')->nullable();
            $table->date('renewal_date')->nullable();
            $table->date('next_billing_date')->nullable();
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
