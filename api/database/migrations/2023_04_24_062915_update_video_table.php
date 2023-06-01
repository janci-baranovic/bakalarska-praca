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
        Schema::table('video', function (Blueprint $table) {
            $table->unsignedBigInteger('lection_id');
            $table->foreign('lection_id')->references('id')->on('lections')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('video', function (Blueprint $table) {
            $table->dropColumn('lection_id');
        });
    }
};
