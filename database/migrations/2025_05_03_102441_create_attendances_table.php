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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->date('date');
            $table->time('checkin')->nullable();
            $table->double('checkin_long')->nullable();
            $table->double('checkin_lat')->nullable();
            $table->text('checkin_photo')->nullable();
            $table->text('checkin_distance')->nullable();
            $table->time('checkout')->nullable();
            $table->double('checkout_long')->nullable();
            $table->double('checkout_lat')->nullable();
            $table->text('checkout_photo')->nullable();
            $table->double('checkout_distance')->nullable();
            $table->integer('late_minutes')->nullable();
            $table->integer('early_leave')->nullable();
            $table->integer('extra_minutes')->nullable();
            $table->enum('status', ['present', 'absent', 'excuse'])->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
