<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('instructor_name');
            $table->string('type')->default('free');
            $table->decimal('price', 8, 2)->nullable();
            $table->string('status');
            $table->string('status_label')->nullable();
            $table->string('next_session_title')->nullable();
            $table->string('start_date')->nullable();
            $table->string('time_range')->nullable();
            $table->string('timezone')->default('بتوقيت مكة المكرمة');
            $table->timestamps();
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
