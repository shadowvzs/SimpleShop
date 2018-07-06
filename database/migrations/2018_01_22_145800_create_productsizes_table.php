<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductSizesTable extends Migration
{

    public function up()
    {
        Schema::create('productsizes', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive, 1=active";
			$table->unsignedInteger('product_id');
			$table->unsignedInteger('size_id');
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });
    }

    public function down()
    {
        Schema::dropIfExists('productsizes');
    }
}
