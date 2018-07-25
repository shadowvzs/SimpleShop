<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categories', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedInteger('parent_id')->default('0');
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive, 1=active";				
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });

		$today = date("Y-m-d H:i:s");
		$default_lang = 1;
		$data = [
			['EVENING','evening',1,0,1,'Evening dresses description...','meta title','meta description'],
			['DATE NIGHT','date_night',1,0,2,'Date Night dresses description...','meta title','meta description'], 
			['(BRIDAL)','bridal',1,0,3,'Bridal dresses description...','meta title','meta description'], 
		];
		
		foreach ($data as $arr) {
			\DB::table('categories')->insert(
				[
					'id' => $arr[4],
					'status' => $arr[2],
					'parent_id' => $arr[3],
					'created_at' => $today,
					'updated_at' => $today,
				]
			);
		
			for($i=1;$i<4;$i++) {
				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Category',
						'foreign_key' => $arr[4],
						'field' => 'name',
						'value' => $arr[0],
						'created_at' => $today,
						'updated_at' => $today,
					]
				);

				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Category',
						'foreign_key' => $arr[4],
						'field' => 'slug',
						'value' => $arr[1],
						'created_at' => $today,
						'updated_at' => $today,
					]
				);	

				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Category',
						'foreign_key' => $arr[4],
						'field' => 'description',
						'value' => $arr[5],
						'created_at' => $today,
						'updated_at' => $today,
					]
				);		
				
				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Category',
						'foreign_key' => $arr[4],
						'field' => 'meta_title',
						'value' => $arr[6],
						'created_at' => $today,
						'updated_at' => $today,
					]
				);	
				
				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Category',
						'foreign_key' => $arr[4],
						'field' => 'meta_description',
						'value' => $arr[7],
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
        Schema::dropIfExists('categories');
    }
}
