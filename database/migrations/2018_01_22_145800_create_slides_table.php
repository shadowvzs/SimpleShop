<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSlidesTable extends Migration {
	
    public function up() {
        Schema::create('slides', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->string('image');
			$table->unsignedInteger('order_id');
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });
    }

    public function down(){
        Schema::dropIfExists('slides');
    }
}
