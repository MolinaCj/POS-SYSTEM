<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSaleshistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sales_history', function (Blueprint $table) {
            $table->increments('id')->unique();
            $table->string('employee_name');
            $table->string('item_name');
            $table->integer('quantity');
            $table->decimal('unit_price', 10, 2);
            $table->decimal('total_price', 10, 2);
            $table->decimal('net_amount', 10, 2);
            $table->decimal('payment_amount', 10, 2);
            $table->timestamp('timestamp')->useCurrent(); // Store date and time of transaction
            $table->string('reference_id', 13); // Reference ID for each transaction

            $table->timestamps(); // Adds created_at and updated_at columns
        });;
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sales_history');
    }
}
