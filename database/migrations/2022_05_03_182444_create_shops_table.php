<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->foreignId("renter_id")->nullable()->references('id')->on('users')->onDelete('set null');
            $table->string('avatar_link')->nullable();
            $table->integer("cashback");
            $table->foreignId('shopping_center_id')->nullable()->references('id')->on('shopping_centers')->onDelete('set null');
            $table->foreignId('category_id')->nullable()->references('id')->on('shop_categories')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('shops');
    }
};
