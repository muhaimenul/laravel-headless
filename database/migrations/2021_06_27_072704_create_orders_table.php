<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('region');
            $table->string('country');
            $table->string('item_Type');
            $table->string('sales_channel');
            $table->string('order_priority');
            $table->string('order_date');
            $table->string('order_id');
            $table->string('ship_date');
            $table->string('units_sold');
            $table->string('unit_price');
            $table->string('unit_cost');
            $table->string('total_revenue');
            $table->string('total_cost');
            $table->string('total_profit');
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
        Schema::dropIfExists('orders');
    }
}
