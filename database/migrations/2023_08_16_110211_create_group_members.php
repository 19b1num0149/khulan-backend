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
        Schema::create('group_members', function (Blueprint $table) {
            $table->id();
            $table->bigInteger("group_id");
            $table->bigInteger("member_id");
            $table->bigInteger("role_id");
            $table->date("joined_at");
            $table->date("left_at");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
<<<<<<<< HEAD:database/migrations/2023_08_14_110557_create_group_members_table.php
        Schema::dropIfExists('group_member');
========
        Schema::dropIfExists('group_members');
>>>>>>>> e6ac7f4 (fixed):database/migrations/2023_08_16_110211_create_group_members.php
    }
};
