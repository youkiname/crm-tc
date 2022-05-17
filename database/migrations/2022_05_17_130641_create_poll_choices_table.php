<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('poll_choices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('poll_id')->references('id')->on('polls')->onDelete('cascade');
            $table->string('title');
        });
    }

    public function down()
    {
        Schema::dropIfExists('poll_choices');
    }
};
