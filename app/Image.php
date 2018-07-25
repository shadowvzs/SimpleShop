<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model {
	protected $table = 'images';
	protected $fillable = ['product_id', 'path'];
 	protected $casts = [
		'id' => 'integer',
		'product_id' => 'integer',
	]; 
}
