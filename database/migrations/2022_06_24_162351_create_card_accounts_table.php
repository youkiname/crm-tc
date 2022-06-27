<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('card_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('shopping_center_id')->references('id')->on('shopping_centers')->onDelete('cascade');
            $table->integer("bonuses_amount");
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('card_accounts');
    }
};
