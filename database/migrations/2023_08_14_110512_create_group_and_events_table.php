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
        Schema::create('group_and_events', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("desc");
            $table->date("date");
            $table->bigInteger("creator_id");
            $table->string("location");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('group_and_event');
    }
};
