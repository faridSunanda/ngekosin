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
        Schema::create('koses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('slug')->unique();
            $table->enum('type', ['putra', 'putri', 'campur'])->default('campur');
            $table->text('address');
            $table->string('city');
            $table->string('district')->nullable();
            $table->bigInteger('price_per_month');
            $table->integer('total_rooms')->default(1);
            $table->integer('available_rooms')->default(1);
            $table->text('description')->nullable();
            $table->json('facilities')->nullable();
            $table->string('thumbnail')->nullable();
            $table->json('images')->nullable();
            $table->enum('status', ['active', 'pending', 'inactive'])->default('active');
            $table->integer('views_count')->default(0);
            $table->integer('clicks_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('koses');
    }
};
