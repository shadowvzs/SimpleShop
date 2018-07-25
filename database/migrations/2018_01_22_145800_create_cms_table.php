<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCmsTable extends Migration
{
    public function up()
    {
        Schema::create('cms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('order_mail')->nullable();
            $table->string('logo')->nullable();
            $table->unsignedTinyInteger('logo_option')->nullable();
            $table->string('currency')->nullable();
            $table->unsignedTinyInteger('maintance')->nullable();
			$table->longText('map')->nullable();
			$table->longText('footer_text')->nullable();
            $table->timestamps();
        });
		
	
		$today = date("Y-m-d H:i:s");

		\DB::table('cms')->insert(
			[
				'id' => 1,
				'name' => 'Page title',
				'order_mail' => 'myemail@gmail.com',
				'logo' => 'logo.png',
				'logo_option' => 1,
				'currency' => 'LEI',
				'maintance' => 1,
				'map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5435.928819643834!2d21.929802999629814!3d47.06054848694138!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x474647e056cf23f9%3A0x9a1c1b519cdc1b5b!2sStrada+Dun%C4%83rea+13%2C+Oradea!5e0!3m2!1sro!2sro!4v1524975411442', 
				'created_at' => $today,
				'updated_at' => $today,
			]
		);
					
    }

    public function down()
    {
        Schema::dropIfExists('cms');
    }
}
