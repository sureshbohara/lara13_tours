<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('analytics_data', function (Blueprint $table) {
            $table->id();
            
            $table->string('page_url', 500)->comment('The URL of the visited page');
            $table->text('browser')->nullable()->comment('User browser and OS info');
            $table->string('session_id')->comment('Unique session identifier');
            $table->string('ip_address', 45)->default('127.0.0.1')->comment('Visitor IP address (supports IPv6)');
            
            $table->timestamps();
            
            $table->index(['session_id', 'created_at']);
            $table->index('created_at');
            $table->index('ip_address');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analytics_data');
    }
};