<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderProduct extends Model {
    protected $table = 'orderproducts';
	protected $fillable = ['order_id','status','total_price','product_id'];
 	protected $casts = [
		'id' => 'integer',
		'status' => 'integer',
		'order_id' => 'integer',
	]; 
}
