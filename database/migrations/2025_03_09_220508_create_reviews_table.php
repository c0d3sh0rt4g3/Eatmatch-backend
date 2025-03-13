<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            // Link review to a restaurant; note that restaurant id is manually entered so we use integer instead of unsignedBigInteger.
            $table->string('restaurant_id');
            $table->foreign('restaurant_id')
                ->references('id')->on('restaurants')
                ->onDelete('cascade');
            // Reviewer id (could reference a users table if needed)
            $table->unsignedBigInteger('reviewer_id');
            // Rating between 1 and 5, title and body of review
            $table->integer('rating');
            $table->string('title', 255);
            $table->text('body');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
