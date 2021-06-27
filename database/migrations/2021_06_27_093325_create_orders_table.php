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
            $table->increments('id');
            $table->double('sum_money');
            $table->string('phone_number', 11);
            $table->string('email', 100);
            $table->string('address_to_ship', 300);
            $table->text('note');
            $table->double('ship_fee');
            $table->double('vat');
            $table->double('money');
            $table->integer('discount');
            $table->integer('payment');
            $table->text('reason_cancer_order');
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
