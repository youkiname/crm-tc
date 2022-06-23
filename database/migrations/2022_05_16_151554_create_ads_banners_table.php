<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ads_banners', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignId('shop_id')->references('id')->on('shops')->onDelete('cascade');
            $table->string('image_link');
            $table->Date('start_date');
            $table->Date('end_date')->nullable();
            $table->boolean('is_active')->default(1);
            $table->string('gender')->nullable();
            $table->integer('min_age');
            $table->integer('max_age');
            $table->integer('min_balance');
            $table->integer('max_balance');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ads_banners');
    }
};
