<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model {

    protected $table = 'productsizes';
    protected $fillable = ['product_id','status','size_id'];
    protected $casts = [
        'id' => 'integer',
        'status' => 'integer',
        'product_id' => 'integer',
        'size_id' => 'integer',
    ];
}
