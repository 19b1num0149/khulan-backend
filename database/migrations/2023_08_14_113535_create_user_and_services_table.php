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
        Schema::create('user_and_services', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("user_id");
            $table->string("description");
            $table->year("founded_year");
            $table->string("phone");
            $table->string("mail");
            $table->string("service_name");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_and_services');
    }
};