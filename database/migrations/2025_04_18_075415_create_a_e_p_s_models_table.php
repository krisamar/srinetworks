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
        Schema::create('a_e_p_s_models', function (Blueprint $table) {
            $table->id();
            $table->string('aadhar_no')->nullable();
            $table->string('phone')->nullable();
            $table->string('name')->nullable();
            $table->string('amount')->nullable();
            $table->string('bank')->nullable();
            $table->integer('apps')->nullable();
            $table->string('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('a_e_p_s_models');
    }
};
