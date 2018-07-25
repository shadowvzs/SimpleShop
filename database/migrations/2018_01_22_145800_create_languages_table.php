<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
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
		
		$today = date("Y-m-d H:i:s");
		$default_lang = 1;
		
		$data = [
			['en.png','en',1, 1, 'English'], 
			['ro.png','ro',0, 2, 'Romana'], 
			['hu.png','hu',0, 3, 'Magyar'], 
		];
		
		foreach ($data as $arr) {
			\DB::table('languages')->insert(
				[
					'id' => $arr[3],
					'flag' => $arr[0],
					'name' => $arr[4],
					'code' => $arr[1],
					'status' => $arr[2],
					'created_at' => $today,
					'updated_at' => $today,
				]
			);
		}
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
