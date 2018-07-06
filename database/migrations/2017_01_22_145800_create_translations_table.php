<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTranslationsTable extends Migration
{

    public function up()
    {
        Schema::create('translations', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive,1=active";
			$table->unsignedTinyInteger('language_id');
			$table->string('model');
			$table->unsignedTinyInteger('foreign_key');
			$table->string('field');
			$table->longText('value')->nullable();
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });
    }

    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
