<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');

            $table->unsignedBigInteger('supplier_id');
            $table->foreign('supplier_id')->references('id')->on('suppliers');

            $table->date('registration_date');

            $table->boolean('is_active')->default(true);

            // bigFloat for subtotal, iva and total
            $table->float('subtotal', 10, 2)->required();
            $table->float('iva', 10, 2)->required();
            $table->float('total', 10, 2)->required();
            $table->text('observations')->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('purchase_orders');
    }
};
