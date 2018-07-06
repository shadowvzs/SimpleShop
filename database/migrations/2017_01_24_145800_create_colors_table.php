<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorsTable extends Migration
{

    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive,1=active";
			$table->string('image')->nullable();
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });
	}

    public function down()
    {
        Schema::dropIfExists('colors');
    }
}
