<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model {

	protected $table = 'colors';
	protected $casts = [
		'id' => 'integer',
		'status' => 'integer',
	];

	public static function getSlug($text) {
		$text = preg_replace('~[^\pL\d]+~u', '-', $text);
		$text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
		$text = preg_replace('~[^-\w]+~', '', $text);
		$text = trim($text, '-');
		$text = preg_replace('~-+~', '-', $text);
		$text = strtolower($text);
		if (empty($text)) {
			return 'untitled';
		}
		return $text;
	}


}
