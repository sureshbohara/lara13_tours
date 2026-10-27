<?php
declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('subtitle', 255)->nullable();
            $table->string('image', 500)->nullable();
            $table->longText('description')->nullable();
            $table->unsignedInteger('order_level')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->index(['status', 'order_level', 'created_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('banners'); }
};