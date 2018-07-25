<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive, 1=active, 2=deleted";
			$table->unsignedTinyInteger('progress')->default('0')->comment = "0=not accepted, 1=accepted, 2=workingonit, 3=done, 4=canceled";
			$table->text('client_data')->nullable();
			$table->decimal('sub_price', 9, 2)->default('0');
			$table->decimal('vat_price', 9, 2)->default('0');
			$table->decimal('total_price', 9, 2);
			$table->timestamps();
			$table->engine = 'InnoDB';			
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
