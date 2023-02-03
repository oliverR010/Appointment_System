<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('firstname')->nullable();
            $table->string('middlename')->nullable();
            $table->string('lastname')->nullable();
            $table->string('contactnumber')->unique();
            $table->string('gender')->nullable();
            $table->string('birthdate')->nullable();
            $table->string('age')->nullable();
            $table->string('identification')->nullable();
            $table->string('identificationtype')->nullable();
            $table->string('address')->nullable();
            $table->string('barangay')->nullable();
            $table->string('account_type')->default("user");
            $table->string('status')->default("pending");
            // $table->integer('otp')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->string('profile_photo_path', 2048)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
};
