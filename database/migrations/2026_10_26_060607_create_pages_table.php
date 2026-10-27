<?php
declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('pages', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);
            $table->string('slug', 255)->unique();
            $table->string('icon', 100)->nullable();
            $table->string('image', 500)->nullable();
            $table->string('short_content', 500)->nullable();
            $table->longText('content')->nullable();
            $table->string('meta_title', 255)->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords', 500)->nullable();
            $table->boolean('show_in_menu')->default(false);
            $table->boolean('show_in_footer')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('order_level')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->index(['status', 'order_level', 'created_at']);
        });
    }
    public function down(): void { Schema::dropIfExists('pages'); }
};