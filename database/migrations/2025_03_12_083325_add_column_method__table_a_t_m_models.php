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
        Schema::table('a_t_m_models', function (Blueprint $table) {
            $table->integer('method')->after('date');
            $table->string('acc_no')->nullable()->after('mobile_number');
            $table->string('ifsc')->nullable()->after('acc_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('a_t_m_models', function (Blueprint $table) {
            //
        });
    }
};
