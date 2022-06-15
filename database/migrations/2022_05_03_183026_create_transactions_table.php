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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('seller_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->foreignId('customer_id')->nullable()->references('id')->on('users')->onDelete('set null');
            $table->foreignId('shopping_center_id')->nullable()->references('id')->on('shopping_centers')->onDelete('set null');
            $table->foreignId('shop_id')->nullable()->references('id')->on('shops')->onDelete('set null');
            $table->integer("bonuses_offset");
            $table->integer("amount");
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
        Schema::dropIfExists('transactions');
    }
};
