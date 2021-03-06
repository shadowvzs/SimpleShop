<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
   
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedInteger('parent_id')->default('0');
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive, 1=active";				
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });
		
    }

    public function down()
    {
        Schema::dropIfExists('categories');
    }
}
