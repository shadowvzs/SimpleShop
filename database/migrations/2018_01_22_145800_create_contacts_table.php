<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->increments('id');
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive, 1=active, 2=banned, 3=deleted";
            $table->unsignedTinyInteger('type')->default('0')->comment = "0=contact, 1=social";
            $table->string('icon')->nullable();
            $table->timestamps();
        });
   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
