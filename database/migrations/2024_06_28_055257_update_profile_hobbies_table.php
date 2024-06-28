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
        Schema::table('profile_hobbies', function (Blueprint $table) {
            $table->unsignedBigInteger('hobby_id');

            $table->foreign('hobby_id')->references('id')->on('hobbies');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('profile_hobbies', function (Blueprint $table) {
            //
        });
    }
};
