<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model {
	protected $table = 'products';
	protected $fillable = ['type','status', 'total_price'];
 	protected $casts = [
		'id' => 'integer',
		'status' => 'integer',
		'type' => 'integer',
		'category_id' => 'integer',
	]; 
  public function slugger($text) {
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
    $text = preg_replace('~[^-\w]+~', '', $text);
    $text = trim($text, '-');
    $text = preg_replace('~-+~', '-', $text);
    $text = strtolower($text);
    if (empty($text)) {
        return 'n-a';
    }
    return $text;
  }

}
