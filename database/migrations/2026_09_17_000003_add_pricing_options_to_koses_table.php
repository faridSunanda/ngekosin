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
        Schema::table('koses', function (Blueprint $table) {
            $table->bigInteger('price_per_day')->nullable()->after('price_per_month');
            $table->bigInteger('price_per_week')->nullable()->after('price_per_day');
            $table->boolean('allow_two_people')->default(false)->after('price_per_week');
            $table->bigInteger('price_2_persons')->nullable()->after('allow_two_people');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('koses', function (Blueprint $table) {
            $table->dropColumn(['price_per_day', 'price_per_week', 'allow_two_people', 'price_2_persons']);
        });
    }
};
