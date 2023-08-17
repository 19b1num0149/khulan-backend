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
        Schema::create('group_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('groups');
            $table->string('name');
            $table->string('description');
            $table->date('date');
            $table->unsignedBigInteger('creator_id');
            $table->foreign('creator_id')->references('id')->on('users');
            $table->string('location');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2023_08_14_110512_create_group_events_table.php
        Schema::dropIfExists('group_event');
========
        Schema::dropIfExists('group_events');
>>>>>>>> e6ac7f4 (fixed):database/migrations/2023_08_16_110126_create_group_events.php
    }
};
