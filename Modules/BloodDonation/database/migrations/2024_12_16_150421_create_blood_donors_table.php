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
        Schema::create('blood_donors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->timestamp('dob')->nullable();
            $table->string('blood_group');
            $table->date('last_donation_date');
            $table->date('next_donation_date');
            $table->text('last_donation_details')->nullable();
            $table->foreignId('division_id')->references('id')->on('divisions');
            $table->foreignId('district_id')->references('id')->on('districts');
            $table->foreignId('upazila_id')->references('id')->on('upazilas');
            $table->text('address')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blood_donors');
    }
};
