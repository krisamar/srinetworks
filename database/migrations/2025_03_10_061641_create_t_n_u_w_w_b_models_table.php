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
        Schema::create('t_n_u_w_w_b_models', function (Blueprint $table) {
            $table->id();
            $table->string('date');
            $table->string('application_no');  
            $table->string('mobile');
            $table->string('name');
            $table->integer('paid');
            $table->integer('status');
            $table->string('others');
            $table->string('id_no');
            $table->string('type');
            $table->string('remarks');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('t_n_u_w_w_b_models');
    }
};
