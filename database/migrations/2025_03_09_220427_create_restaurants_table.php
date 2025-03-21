<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('restaurants', function (Blueprint $table) {
            // Manually entered restaurant id (no auto-increment)
            $table->string('id')->primary();
            $table->string('name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('restaurants');
    }
};
