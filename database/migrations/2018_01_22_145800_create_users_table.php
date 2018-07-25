<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
		
		$today = date("Y-m-d H:i:s");
		\DB::table('users')->insert(
		[
			'id' => 1,
			'name' => "Site owner",
			'email' => "myemail@gmail.com",
			'password' => '$2y$10$XsLC.kxHdFoeqb0gPNb4j.ECR7MIpI8OKf73XUPo6LjqVJd6qsR/2',
			'created_at' => $today,
			'updated_at' => $today,
		]);
				
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
