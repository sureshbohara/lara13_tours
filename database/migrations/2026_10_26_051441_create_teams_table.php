<?php
declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('teams', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('email', 255)->nullable();
            $table->string('address', 500)->nullable();
            $table->string('designation')->nullable();
            $table->longText('bio')->nullable();
            $table->string('image', 500)->nullable();
            $table->string('facebook', 500)->nullable();
            $table->string('youtube', 500)->nullable();
            $table->string('tiktok', 500)->nullable();
            $table->string('instagram', 500)->nullable();
            $table->unsignedInteger('order_level')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->index(['status', 'order_level', 'created_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('teams'); }
};