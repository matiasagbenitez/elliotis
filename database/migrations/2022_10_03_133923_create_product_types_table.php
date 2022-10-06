<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();

            $table->string('name');

            $table->unsignedBigInteger('measure_id')->nullable();
            $table->foreign('measure_id')->references('id')->on('measures');

            $table->unsignedBigInteger('unity_id')->nullable();
            $table->foreign('unity_id')->references('id')->on('unities');

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_types');
    }
};
