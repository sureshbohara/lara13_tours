<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->foreignId('fixed_departure_id')->nullable()->constrained('fixed_departures')->nullOnDelete();
            
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->integer('number_of_people')->default(1);
            $table->date('travel_date')->nullable();
            $table->text('message')->nullable();
            
            $table->string('status')->default('pending');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('bookings');
    }
};