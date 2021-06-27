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
            $table->string('Region')->nullable();
            $table->string('Country')->nullable();
            $table->string('Item Type');
            $table->string('Sales Channel')->nullable();
            $table->string('Order Priority')->nullable();
            $table->string('Order Date');
            $table->string('Order ID');
            $table->string('Ship Date')->nullable();
            $table->string('Units Sold')->nullable();
            $table->string('Unit Price')->nullable();
            $table->string('Unit Cost')->nullable();
            $table->string('Total Revenue');
            $table->string('Total Cost');
            $table->string('Total Profit');
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
