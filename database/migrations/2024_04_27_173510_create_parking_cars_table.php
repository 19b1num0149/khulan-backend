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
        Schema::create('parking_cars', function (Blueprint $table) {
            $table->id();   
            $table->integer("user_id");
            $table->integer("parking_id");
            $table->string("car_number", 7);
            $table->timestamp('parked_at') ->nullable();
            $table->timestamp('moved_at') ->nullable();
            $table->timestamp('ordered_at') -> nullable();
            $table->timestamp('order_cancelled_at') -> nullable();
            $table->timestamp('paid_at') -> nullable();
            $table->boolean('is_active') -> default('1');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_cars');
    }
};
