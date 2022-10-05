<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->date('date');

            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->integer('supplier_order_id')->nullable();

            $table->unsignedBigInteger('payment_condition_id')->required();
            $table->foreign('payment_condition_id')->references('id')->on('payment_conditions');

            $table->unsignedBigInteger('payment_method_id')->required();
            $table->foreign('payment_method_id')->references('id')->on('payment_methods');

            $table->unsignedBigInteger('voucher_type_id')->required();
            $table->foreign('voucher_type_id')->references('id')->on('voucher_types');

            $table->string('voucher_number')->nullable();

            $table->decimal('subtotal', 10, 2)->required();
            $table->decimal('iva', 10, 2)->required();
            $table->decimal('total', 10, 2)->required();

            $table->decimal('weight', 10, 2)->required();
            $table->string('weight_voucher')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchases');
    }
};
