<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model {

	protected $table = 'colors';
	protected $casts = [
		'id' => 'integer',
		'status' => 'integer',
	];

}