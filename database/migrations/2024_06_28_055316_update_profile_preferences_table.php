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
        Schema::table('profile_preferences', function (Blueprint $table) {
            $table->unsignedBigInteger('preference_id');

            $table->foreign('preference_id')->references('id')->on('preferences');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_preferences', function (Blueprint $table) {
            //
        });
    }
};
