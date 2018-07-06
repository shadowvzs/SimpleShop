<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizesTable extends Migration
{

    public function up()
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive,1=active";
			$table->string('name');
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });

	}

    public function down()
    {
        Schema::dropIfExists('sizes');
    }
}
