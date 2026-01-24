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
        Schema::create('student_applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->date('date_of_birth');
            $table->string('nationality');
            $table->string('passport_number');
            $table->enum('education_level', ['high_school', 'bachelors', 'masters', 'phd']);
            $table->string('desired_course');
            $table->string('desired_university');
            $table->string('target_country');
            $table->decimal('gpa', 3, 2);
            $table->string('english_test_type')->nullable();
            $table->decimal('english_score', 4, 1)->nullable();
            $table->text('personal_statement');
            $table->enum('status', ['pending', 'under_review', 'approved', 'rejected', 'completed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->decimal('service_fee', 10, 2)->default(0);
            $table->enum('payment_status', ['pending', 'paid', 'refunded'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_applications');
    }
};
