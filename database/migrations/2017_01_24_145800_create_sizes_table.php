<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSizesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sizes', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive,1=active";
			$table->string('name');
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });
    
		$today = date("Y-m-d H:i:s");
		$data = ['XXS','XS', 'S', 'M', 'L', 'XL', 'XXL'];
		$id = 0;
		foreach ($data as $size) {
			$id++;
			\DB::table('sizes')->insert(
				[
					'id' => $id,
					'name' => $size,
					'status' => 1,
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
        Schema::dropIfExists('sizes');
    }
}
