<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('travel_package_id')->constrained()->onDelete('cascade');
            $table->string('booking_reference')->unique();
            $table->integer('number_of_travelers');
            $table->json('traveler_details');
            $table->decimal('total_price', 10, 2);
            $table->decimal('paid_amount', 10, 2)->default(0);
            $table->enum('status', ['pending', 'confirmed', 'paid', 'cancelled', 'completed'])->default('pending');
            $table->text('special_requests')->nullable();
            $table->text('admin_notes')->nullable();
            $table->datetime('booking_date');
            $table->datetime('payment_due_date');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};