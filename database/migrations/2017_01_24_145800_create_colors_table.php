<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateColorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive,1=active";
			$table->string('image')->nullable();
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });

		$today = date("Y-m-d H:i:s");
		$default_lang = 1;
		
		$data = [
			['Color 1', 1, 'color1.jpg', 1],
			['Color 2', 1, 'color2.jpg', 2],
			['Color 3', 1, 'color3.jpg', 3],
			['Color 4', 1, 'color4.jpg', 4],
			['Color 5', 1, 'color5.jpg', 5],
			['Color 6', 1, 'color6.jpg', 6],
			['Color 7', 1, 'color7.jpg', 7],
			['Color 8', 1, 'color8.jpg', 8],
			['Color 9', 1, 'color9.jpg', 9],
		];

			
		foreach ($data as $color) {
			\DB::table('colors')->insert(
				[
					'id' => $color[3],
					'status' => $color[1],
					'image' => $color[2],
					'created_at' => $today,
					'updated_at' => $today,					
				]
			);

			\DB::table('translations')->insert(
				[
					'language_id' => $default_lang,
					'model' => 'Color',
					'foreign_key' => $color[3],
					'field' => 'name',
					'value' => $color[0],
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
        Schema::dropIfExists('colors');
    }
}
