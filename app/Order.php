<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $table = 'orders';
	protected $fillable = ['status','progress','user_id','total_price'];
 	protected $casts = [
		'id' => 'integer',
		'status' => 'integer',
		'progress' => 'integer',
	]; 
}
