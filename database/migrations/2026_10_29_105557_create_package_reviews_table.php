<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('package_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->string('name');
            $table->string('email');
            $table->string('address')->nullable();
            $table->text('review');
            $table->tinyInteger('rating')->default(5); 
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('package_reviews');
    }
};