<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('reset_password_codes', function (Blueprint $table) {
            $table->id();
            $table->string('email', 100)->unique();
            $table->string('code');
            $table->dateTime('expires_at');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('reset_password_codes');
    }
};
