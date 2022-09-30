<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();

            $table->string('businness_name')->required();

            $table->unsignedBigInteger('iva_condition_id')->nullable();
            $table->foreign('iva_condition_id')->references('id')->on('iva_conditions')->onDelete('set null');

            $table->string('cuit')->nullable();
            $table->string('last_name')->required();
            $table->string('first_name')->required();

            $table->string('adress')->nullable();

            $table->unsignedBigInteger('locality_id')->nullable();
            $table->foreign('locality_id')->references('id')->on('localities')->onDelete('set null');

            $table->string('phone')->nullable();
            $table->string('email')->nullable();

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('clients');
    }
};
