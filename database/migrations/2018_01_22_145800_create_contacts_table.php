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
		
		$today = date("Y-m-d H:i:s");
		$default_lang = 1;
		$data = [
			['Phone','074444444',1,0,'phone.png', 1],
			['City','Oradea',1,0,'', 2], 
			['Judet','Bihor',1,0,'', 3], 
			['Skype','.....',1,0,'skype.png', 4], 
			['WhatsApp','......',1,0,'whatsapp.png', 5], 
			['Address','str z, nr. x, ap. y',1,0,'', 6], 
			['Email','valami@valami.hu',1,0,'email.png', 7], 

			['Facebook','https://valami.com',1,1,'facebook.png', 9], 
			['YouTube','https://valami.com',1,1,'youtube.png', 10],	
			['Pinterest','https://valami.com',1,1,'pinterest.png', 11],	
			['Google Plus','https://valami.com',1,1,'googleplus.png', 12],	
			['Twitter','https://valami.com',1,1,'twitter.png', 13],	
			['LinkedIn','https://valami.com',1,1,'linkedin.png', 14],	
			['Instagram','https://valami.com',1,1,'instagram.png', 15],				
		];
		
		foreach ($data as $arr) {
			\DB::table('contacts')->insert(
				[
					'id' => $arr[5],
					'status' => $arr[2],
					'type' => $arr[3],
					'icon' => $arr[4],
					'created_at' => $today,
					'updated_at' => $today,
				]
			);
			
			for ($i=1;$i<3;$i++) {
				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Contact',
						'foreign_key' => $arr[5],
						'field' => 'name',
						'value' => $arr[0],
						'created_at' => $today,
						'updated_at' => $today,
					]
				);	

				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Contact',
						'foreign_key' => $arr[5],
						'field' => 'value',
						'value' => $arr[1],
						'created_at' => $today,
						'updated_at' => $today,
					]
				);		
			}			
		}
				
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
