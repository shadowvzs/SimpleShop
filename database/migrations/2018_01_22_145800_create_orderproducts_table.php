<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderProductsTable extends Migration
{

    public function up()
    {
        Schema::create('orderproducts', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedTinyInteger('status')->default('1');
			$table->unsignedInteger('order_id');
			$table->text('product_data');
			$table->unsignedInteger('amount');
			$table->decimal('sub_price', 9, 2)->default('0');
			$table->decimal('vat_price', 9, 2)->default('0');
			$table->decimal('total_price', 9, 2);
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });
    }

    public function down()
    {
        Schema::dropIfExists('orderproducts');
    }
}
