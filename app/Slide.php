<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model {
    protected $table = 'slides';
    protected $fillable = ['image', 'order_id'];
	protected $casts = [
		'id' => 'integer',
		'order_id' => 'integer',
	];

}
