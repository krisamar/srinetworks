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
        Schema::table('a_e_p_s_models', function (Blueprint $table) {
            $table->string('date')->nullable()->after('id');
            $table->string('remarks')->nullable()->after('image');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('a_e_p_s_models', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->dropColumn('remarks');
        });
    }
};
