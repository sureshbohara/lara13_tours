<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique()->nullable();
            $table->index('slug'); 
            
            // Media
            $table->string('image')->nullable();
            $table->string('feature_image')->nullable();
            $table->json('gallery')->nullable();
            $table->text('map')->nullable(); 
            
            // Pricing
            $table->decimal('trip_previous_price', 10, 2)->nullable();
            $table->decimal('trip_price', 10, 2)->nullable();
            $table->json('group_size_price')->nullable();
            
            // Content
            $table->text('excerpt')->nullable();
            $table->longText('description')->nullable();
            $table->longText('content')->nullable();
            $table->json('highlight_key')->nullable();
            $table->json('included_data')->nullable();
            $table->json('excluded_data')->nullable();
            $table->json('faqs')->nullable();
            $table->json('itinerary_data')->nullable();
            

            $table->json('general')->nullable();
            $table->json('lower_body')->nullable();
            $table->json('upper_body')->nullable();
            $table->json('footwear')->nullable();
            $table->json('accessories')->nullable();
            $table->json('activities')->nullable();
            
            // Trip Facts
            $table->string('duration')->nullable();
            $table->string('transportation')->nullable();
            $table->string('trip_grading')->nullable();
            $table->string('max_altitude')->nullable();
            $table->string('accommodation')->nullable();
            $table->string('meals')->nullable();
            $table->string('best_season')->nullable();
            
            $table->string('destination')->nullable(); 

            $table->integer('view_count')->default(0);
            $table->boolean('status')->default(true);
            $table->integer('order_level')->default(0);
            $table->string('display_on')->nullable();
            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            
            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();
            
            
            $table->timestamps();
            
            $table->index('status');
            $table->index('order_level');
        });

        Schema::create('package_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->foreignId('category_id')->constrained('categories')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['package_id', 'category_id']);
        });

        Schema::create('fixed_departures', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->constrained('packages')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->decimal('discount_price', 10, 2)->nullable();
            $table->integer('max_seats')->default(0);
            $table->integer('booked_seats')->default(0);
            $table->text('description')->nullable();
            $table->string('status')->default('active'); 
            $table->timestamps();
            
            $table->index(['package_id', 'start_date', 'status']);
        });
    }

    public function down(): void {
        Schema::dropIfExists('fixed_departures');
        Schema::dropIfExists('package_categories');
        Schema::dropIfExists('packages');
    }
};