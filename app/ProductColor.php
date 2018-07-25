<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model {
    
    protected $table = 'productcolors';
	protected $fillable = ['product_id','status','color_id'];
 	protected $casts = [
		'id' => 'integer',
		'status' => 'integer',
		'product_id' => 'integer',
		'color_id' => 'integer',
	];
}
