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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('fullname');
            $table->string('nickname')->nullable();
            $table->date('birthday');
            $table->boolean('gender');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->boolean('contact');
            $table->double('membership_fee');
            $table->boolean('image_use');
            $table->string('address');
            $table->string('note')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
