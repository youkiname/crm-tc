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
        Schema::create('admin_shopping_center_bundles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('admin_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('shopping_center_id')->references('id')->on('shopping_centers')->onDelete('cascade');
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
        Schema::dropIfExists('admin_shopping_center_bundles');
    }
};
