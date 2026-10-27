<?php
declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            $table->string('display_on')->default('default');
            $table->text('question');
            $table->text('answer');
            $table->integer('order_level')->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
            $table->index(['status', 'order_level', 'display_on']);
        });
    }
    public function down(): void { Schema::dropIfExists('faqs'); }
};