<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive,1=active";
			$table->string('name')->nullable();
			$table->string('flag')->nullable();
			$table->string('code')->nullable();
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });

    }

    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
