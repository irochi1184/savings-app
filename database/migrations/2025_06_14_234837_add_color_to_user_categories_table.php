<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('user_categories', function (Blueprint $table) {
            $table->string('color', 7)->nullable()->after('icon'); // 例: "#AABBCC"
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_categories', function (Blueprint $table) {
            //
        });
    }
};
