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

	public static function getRecommended($order, $limit=4){
		$products = Product::take($limit);
		if ($order === "random") {
			$products = $products->inRandomOrder();
		} else if ($order === "last") {
			$products = $products->orderBy('id', 'desc');
		}

		return $products->get();
	}

	public static function getProducts($option){

		$TranslationModel = new \App\Translation;
		$CategoryModel = new \App\Category;
		$title = "Search for ";
		$links = [];
		$language = $option['language'] ?? \App\Language::getLocale();
 	    $products = Product::where('status', 1);
 	    $limit = empty($option['page_limit']) ? 4 : intval($option['page_limit']);
		$page_index = !empty($option['page_index']) ? explode('page_', $option['page_index'])[1] : 0;
		$min_price = $option['min_price'] ?? false;
		$max_price = $option['max_price'] ?? false;
		$color = $option['color'] ?? false;
		$size = $option['size'] ?? false;
  	    $offset = $limit * $page_index;
 	    $keyword = $option['keyword'] ?? "";
 	    $category_slug = strtolower($option['category'] ?? "");
		$pagination_range = 3;
		$sort_by = $option['sortby'] ?? "";
		$link = [];

 	    if (!empty($option['sortby'])) {
			$order = explode('-', $option['sortby']);
			$order_dir = $order[1] ?? 'ASC';
			$order_field = $order[0];
			if ($order_field == "price") {
				$order_field = "total_price";
			}
 	    	$products = $products->orderBy($order_field, $order_dir);
			$link[] = "order_field=".$order_field;
			$link[] = "order_dir=".$order_dir;
 	    }

 	    if (!empty($option['category'])) {
 		    $cat = $TranslationModel::where('value', $category_slug )
 			    ->where('model', 'Category')
 			    ->where('field', 'slug')
 			    ->first()
 			    ->toArray();
 		    if (!empty($cat) && $cat['status'] == 1) {
 			    $cat_ids = $CategoryModel::getCatFamily($cat['foreign_key']);
				$cat = array_values(Translation::getTranslation($language['id'], 'Category', [Category::find($cat['foreign_key'])->toArray()]))[0];
 			    $products = $products->whereIn('category_id', $cat_ids);
 		    } else {
				$products = $products->where('category_id', -1);
			}
			$link[] = "category=".$option['category'];
  	    }

 	    if (!empty($keyword)) {
 		    $product_ids = $TranslationModel::where('value', 'like', '%'.$keyword.'%')
 			    ->where('model', 'Product')
 			    ->where('field', 'name')
 			    ->get();
			$product_ids = !empty($product_ids) ? array_column($product_ids->toArray(), 'foreign_key') : [];
			$link[] = "keyword=".$keyword;
  	    }

		if ($color) {
			$sel_color = $TranslationModel::where('value', $color )
			 			    ->where('model', 'Color')
			 			    ->where('field', 'slug')
			 			    ->first();

			if (!empty($sel_color['id'])) {
				$tmp = \App\ProductColor::where('color_id', $sel_color['foreign_key'])->get();
				if (!empty($tmp)) {
					$tmp = array_column($tmp->toArray(), 'product_id');
					$product_ids = isset($product_ids) ? array_intersect($product_ids, $tmp) : $tmp;
				} else {
					$product_ids = [];
				}
			} else {
				$product_ids = [];
			}
		}

		if ($size) {
			$sel_size = $tmp = \App\Size::where('name', $size)->first();
			if (!empty($sel_size['id'])) {
				$tmp = \App\ProductSize::where('size_id', $sel_size['id'])->get();
				if (!empty($tmp)) {
					$tmp = array_column($tmp->toArray(), 'product_id');
					$product_ids = isset($product_ids) ? array_intersect($product_ids, $tmp) : $tmp;
				} else {
					$product_ids = [];
				}
			} else {
				$product_ids = [];
			}
		}

		if ($min_price) {
			$products = $products->where('total_price', '>=', intval($min_price));
		}

		if ($max_price) {
			$products = $products->where('total_price', '<=', intval($max_price));
		}

		if (isset($product_ids)) {
			$products = $products->whereIn('id', $product_ids);
		}

 	    $count = $products->count();
		$max_count = ceil($count / $limit);

 	    if ($count > 0) {
 		    $products = $products->offset($offset)->limit($limit)->get()->toArray();
			if (!empty($products)) {
	 		    $products = array_values($TranslationModel::getTranslation($language['id'], 'Product', $products));
				if ($max_count > 1) {
					$link = (empty($link) ? '?' : '?'.implode('&', $link).'&').'page_index=';
					$index = $page_index+1;

					$links[] = ['<<', 'first', 0, $index > 1 ? '' : 'disabled'];
					$links[] = ['<', 'previous', $index-1, $index > 1 ? '' : 'disabled'];

					$diff = $index - $pagination_range;
					$min = $diff < 0 ? 0 : $diff;
					$diff = $index + $pagination_range;
					$max = $diff > $max_count ? $max_count : $diff;
					$i = $min;

					for (;$i<$max;$i++) {
						$links[] = [$i+1, 'page_'.$i, $i, $page_index != $i ? '' : 'selected'];
					}

					$links[] = ['>', 'next', $index, $index < $max_count ? '' : 'disabled'];
					$links[] = ['>>', 'last', $max_count-1, $index < $max_count ? '' : 'disabled'];
				}
			}
 	    } else {
			$products = [];
		}

 	    return [
 		    'products' => array_values($products),
			'page_id' => 3,
 		    'page' => [
 			    'meta_title' => $cat['meta_title'] ?? $title,
 			    'meta_keyword' => $cat['meta_keyword'] ?? "",
 			    'meta_description' => $cat['meta_description'] ?? ""
 		    ],
 		    'pagination' => [
				'count' => $count,
 			    'keyword' => $keyword,
				'category' => $category_slug,
				'min_price' => $min_price ?? false,
				'max_price' => $max_price ?? false,
				'color' => $color,
				'size' => $size,
				'links' => $links,
				'index' => $page_index,
				'page_limit' => $limit,
 			    'max_index' => ceil($count / $limit),
				'orderby' => $sort_by
 		    ],
 	   ];

	}

}
