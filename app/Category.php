<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model {

	protected $table = 'categories';
	protected $fillable = ['name', 'status', 'slug','description'];
	protected $casts = [
		'id' => 'integer',
		'parent_id' => 'integer',
		'status' => 'integer',
	];

	public static function slug($text) {
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

	public static function getCatFamily($id) {
		$cats = Category::where('parent_id', $id)->where('status', 1)->get()->toArray();
		return !empty($cats) ? array_merge([$id], array_column($cats, 'id')) : [$id];
	}

	public static function sortPages($data) {
		$temp = [];
		foreach ($data as $page) {
			$parent = $page['parent_id'];
			$id = $page['id'];
			if ($parent == 0) {
				if (!empty($temp[$id])) {
					$temp[$id] = array_merge($temp[$id], $page);
				} else {
					$temp[$id] = $page;
				}
			} else {
				if (empty($temp[$parent])) { $temp[$parent] = ['Child' => []]; }
				if (empty($temp[$parent]['Child'])) { $temp[$parent]['Child'] = []; }
				array_push($temp[$parent]['Child'], $page);
			}
		}
		return $temp;
	}

}
