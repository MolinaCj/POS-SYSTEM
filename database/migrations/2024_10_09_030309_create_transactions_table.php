<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->increments('transaction_id')->unique(); // Transaction ID
            $table->unsignedBigInteger('cashier_id')->nullable(); // Employee ID
            $table->unsignedBigInteger('product_id'); // Product ID
            $table->string('item_name');
            $table->integer('quantity'); // Quantity
            $table->decimal('unit_price', 10, 2); // Unit Price
            $table->decimal('total_price', 10, 2); // Total Price
            $table->decimal('tax_amount', 10, 2)->nullable(); // Tax Amount
            $table->decimal('net_amount', 10, 2)->nullable(); // Net Amount or the total amount of the transaction
            $table->string('reference_no', 13);

            $table->timestamps();

            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
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
}
