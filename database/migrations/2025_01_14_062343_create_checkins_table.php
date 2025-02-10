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
        Schema::create('checkins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('qrcode_id')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->boolean('role')->default(0);
            $table->string('fullname')->nullable();
            $table->string('phone_number')->nullable();
            $table->date('birthday')->nullable();
            $table->timestamps();

            $table->foreign('qrcode_id')->references('id')->on('qrcodes')->onUpdate('cascade');
            $table->foreign('member_id')->references('id')->on('members')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('checkins');
    }
};
