<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{

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
			'name' => "John Smith",
			'email' => "johhny@smoth.com",
			'password' => '---- need a existing encrypted password here ----',
			'created_at' => $today,
			'updated_at' => $today,
		]);
				
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
}
