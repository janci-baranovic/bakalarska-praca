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
        Schema::table('lections', function (Blueprint $table) {
            $table->string('title');
            $table->string('image')->default('/public/defaultDocker.png');
            $table->text('content');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lections', function (Blueprint $table) {
            $table->dropColumn('title');
            $table->dropColumn('image');
            $table->dropColumn('content');
        });
    }
};
