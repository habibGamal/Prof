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
        Schema::create('codes_requests', function (Blueprint $table) {
            $table->id();
            $table->enum('code_type', ['monthly', 'lecture']);
            $table->foreignId('course_id')->constrained()->onDelete('cascade');
            $table->integer('number_required');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('codes_requests');
    }
};
