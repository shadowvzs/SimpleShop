<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration {

    public function up() {
        Schema::create('products', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive, 1=active";
			$table->unsignedTinyInteger('type')->default('1')->comment = "0=bag, 1=cloth";
			$table->unsignedInteger('category_id')->index();
			$table->string('main_image')->default("");
			$table->decimal('total_price', 9, 2);
			$table->timestamps();	
            $table->engine = 'InnoDB';			
        });
    }


    public function down() {
        Schema::dropIfExists('products');
    }
}
