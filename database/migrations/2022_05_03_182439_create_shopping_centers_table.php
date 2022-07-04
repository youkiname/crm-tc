<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shopping_centers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('address');
            $table->string('avatar_link')->nullable();
            $table->foreignId('city_id')->nullable()->references('id')->on('cities')->onDelete('set null');
            $table->string('coordinates');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shopping_centers');
    }
};
