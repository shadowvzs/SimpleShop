<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Translation;
use \App\Image;
use \App\Size;
use \App\Color;
use \App\Product;
use \App\ProductColor;
use \App\ProductSize;
use \App\Category;
use Illuminate\Support\Facades\Session;

class ProductController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth', [
            'except' => [
                'prod',
                'collection',
                'view',
                'test',
                'searchProduct'
            ]
        ]);
    }

    public function index() {
        $language = \App\Language::getLocale();
        $products = Translation::getTranslation($language['id'], 'Product', Product::all()->toArray(), true);
        return view('product.index', ['products' => $products]);
    }

    public function add() {
        $language = \App\Language::getLocale();
        $colors = Translation::getTranslation($language['id'], 'Color', Color::all()->toArray());
        $sizes = Size::all()->toArray();
        return view('product.add',['sizes' => $sizes, 'colors' => $colors]);
    }

    public function edit($id) {
        $language = \App\Language::getLocale();
        $colors = Translation::getTranslation($language['id'], 'Color', Color::all()->toArray() );
        $sizes = Size::all()->toArray();
        $product = Translation::getTranslation($language['id'], 'Product', Product::find($id)->toArray(), true, $id );
        $product_images = Image::where('product_id', $id)->get()->toArray();
        $product_size = array_column(ProductSize::where('product_id', $id)->get()->toArray(), 'size_id');
        $product_color = array_column(ProductColor::where('product_id', $id)->get()->toArray(), 'color_id');

        return view('product.edit', [
            'sizes' => $sizes,
            'colors' => $colors,
            'product' => $product,
            'product_images' => $product_images,
            'product_size' => $product_size,
            'product_color' => $product_color
        ]);

    }

    public function delete_image($id=null) {
        $image = Image::find($id);
        $path =   './img/products/'.$image['path'];
        if (file_exists($path)) {
            unlink($path);
        }
        Image::destroy($id);
        echo 'true';
    }

    public function delete($id=null) {
        $images = Image::where('product_id', $id)->get()->toArray();
        foreach ($images as $image) {
            $path = './img/products/'.$image['path'];
            if (file_exists($path)) {
                unlink($path);
            }
        }
        Image::where('product_id', $id)->delete();
        ProductColor::where('product_id', $id)->delete();
        ProductSize::where('product_id', $id)->delete();
        Translation::where('foreign_key', $id)->where('model', 'Product')->delete();
        Product::destroy($id);

        return redirect('/product');
    }


    public function save(Request $request) {

        $product = $request->id > 0 ? Product::find($request->id) : new Product;
        $product->category_id = $request->category_id;
        $product->total_price = $request->price;
        $product->status = empty($request->status) ? 0 : 1;
        $json = json_decode($request->json);
        $lang = $request->language;

        if ($request->id > 0) {
            //if this was edit then i delete the old translation and product data except images
            $id = $request->id;
            Translation::where('language_id', $lang)
            ->where('model', 'Product')
            ->where('foreign_key', $id)->delete();

            ProductSize::where('product_id', $id)->delete();
            ProductColor::where('product_id', $id)->delete();
            if (substr($json->main_image, 0, 1) === "_") {
                $product->main_image = Image::find(substr($json->main_image, 1))['path'];
            }
        }

        if ($product->save()) {
            $id = $product['id'];
            $trans_fields = Translation::$virtual_fields['Product'];

            foreach ($trans_fields as $trans_field) {
                $value = $request->$trans_field;
                if ($trans_field == "slug") {
                    $value = $product->slugger($request->name);
                }

                Translation::create([
                    'model' => 'Product',
                    'foreign_key' => $id,
                    'field' => $trans_field,
                    'language_id' => $lang,
                    'value' => $value,
                ]);
            }

            foreach($json->size as $size) {
                ProductSize::create([
                    'product_id' => $id,
                    'size_id' => $size,
                ]);
            }

            foreach($json->color as $color) {
                ProductColor::create([
                    'product_id' => $id,
                    'color_id' => $color,
                ]);
            }

            if (!empty($_FILES['images'])) {
                foreach($_FILES['images']['tmp_name'] as $key => $temp_file) {
                    if (empty($temp_file)) { continue; }
                    $filename = time().$_FILES['images']['name'][$key];
                    move_uploaded_file($temp_file, "img/products/".$filename);
                    Image::create([
                        'product_id' => $id,
                        'path' => $filename,
                    ]);
                    if ($key === $json->main_image) {
                        $product->main_image = $filename;
                        $product->save();
                    }
                }
            }
        } else {
            App::abort(500, 'Error');
        }
        return redirect('/product');
    }

    public function collection1($slug=null) {
        $title = "Collection";
        $language = \App\Language::getLocale();
        $page_id = 3;
        if ($slug == 'hot') {
            $title = "Top 10";
            $products = Product::take(10)->orderBy('id', 'DESC')->get();
            $page_id = 2;
            if (!empty($products)) {
                $products = $products->toArray();
            }
        } else if (empty($slug) || $slug == 'all') {
            $cat_ids = array_merge([0], array_column(Category::where('status', 1)->get()->toArray() ?? [['id' => 0]], 'id'));
            $products = Product::whereIn('category_id', $cat_ids)->get();
            if (!empty($products)) {
                $products = $products->toArray();
            }
        } else {
            $cat = Translation::where('value', (strtolower($slug) ))
				->where('model', 'Category')
				->where('field', 'slug')
				->first()
				->toArray();

            if (empty($cat) || $cat['status'] != 1) { return; }
            $cat = array_values(Translation::getTranslation(
                $language['id'],
                'Category',
                [Category::find($cat['foreign_key'])->toArray()])
            )[0];

            $cat_ids = Category::getCatFamily($cat['id']);
            $products = Product::whereIn('category_id', $cat_ids)->get()->toArray();
        }

        $categories = Category::sortPages(
            array_values(
                Translation::getTranslation(
                    $language['id'],
                    'Category',
                    Category::all()->toArray()
                )
            )
        );

        if (!empty($products)) {
            $products = Translation::getTranslation($language['id'], 'Product', $products );
        }

        return view('product.collection', [
            'products' => array_values($products),
            'cms' => \App\Cms::first()->toArray(),
            'cats' => $categories,
            'page' => [
                'meta_title' => $cat['meta_title'] ?? $title,
                'meta_keyword' => $cat['meta_keyword'] ?? "",
                'meta_description' => $cat['meta_description'] ?? ""
            ],
            'page_id' => $page_id
        ]);
    }

    public function view($slug) {

        $page_id = 3;
        $language = \App\Language::getLocale();
        if (is_numeric($slug)) {
            $prod = Translation::getTranslation($language['id'], 'Product', [
                Product::where('id', $slug)
    				->where('status', 1)
    				->first()
    				->toArray()
            ]);
        } else {
            $prod_trans = Translation::where('value', (strtolower($slug) ))
    				->where('field', 'slug')
    				->where('model', 'Product')
    				->first();
            if (empty($prod_trans['foreign_key'])) {
                return abort(404);
            }
            $prod = Translation::getTranslation($language['id'], 'Product', [
                Product::where('id', $prod_trans['foreign_key'])
    				->where('status', 1)
    				->first()
    				->toArray()
            ]);
        }
        $prod = $prod[array_keys($prod)[0]];

        $colors = ProductColor::where('product_id', $prod['id'])->where('status', 1)->get()->toArray();
        $sizes = ProductSize::where('product_id', $prod['id'])->where('status', 1)->get()->toArray();
        $prod['colors'] =  !empty($colors)
    		? array_values(Translation::getTranslation(
    			$language['id'],
    			'Color',
    			Color::whereIn('id', array_column($colors, 'color_id'))
    				->where('status', 1)
    				->get()
    				->toArray()
    		))
    		: [];

        $prod['sizes'] =  !empty($sizes)
            ? array_values(Size::whereIn('id', array_column($sizes, 'size_id'))
    			->where('status', 1)
    			->get()
    			->toArray())
            : [];
        $cat = Category::where('id', $prod['category_id'])
            ->where('status', 1)
            ->first();
        $prod['category'] = Translation::getTranslation($language['id'], 'Category',
            !empty($cat) ? [$cat->toArray()] : []
        );
        $prod['images'] = Image::where('product_id', $prod['id'])->get()->toArray();
        $prod['description'] = nl2br($prod['description'] ?? "");

        return view('product.view', [
            'prod' => $prod,
            'cms' => \App\Cms::first()->toArray(),
            'page' => [
                'meta_title' => $prod['meta_title'] ?? "",
                'meta_keyword' => $prod['meta_keyword'] ?? "",
                'meta_description' => $prod['meta_description'] ?? ""
            ],
            'page_id' => $page_id
        ]);

    }


    public function searchProduct($query) {

        $language = \App\Language::getLocale();
        $data = explode('/',$query);
        $maskID = array_splice($data, 0, 1)[0];
        $mask = str_split(base_convert(intval($maskID), 10, 2));
        $mask_len = count($mask);
        $options = [];
        $page_id = 3;

        $searchIndexs = ['keyword','category','page_index', 'page_limit','color','size','min_price', 'max_price', 'sortby'];

        for ($i=$mask_len-1; $i>=0;$i--) {
            if ($mask[$i] != 0) {
                $options[$searchIndexs[$mask_len-$i-1]] = array_splice($data, 0, 1)[0];
            }
        }
        if (!empty($options['sortby'])) {
            $option['sortby'] = $options['sortby'];
       }

        $categories = Category::sortPages(
            array_values(
                Translation::getTranslation(
                    $language['id'],
                    'Category',
                    Category::all()->toArray()
                )
            )
        );

        $random_products = array_values(Translation::getTranslation($language['id'], 'Product', Product::inRandomOrder()->take(4)->get()->toArray() ));

        return view('product.collection', array_merge([
            'cms' => \App\Cms::first()->toArray(),
            'cats' => $categories,
            'random_products' => $random_products,
        ], Product::getProducts($options) ));

    }

    public function collection($slug=null) {

        $title = "Collection";
        $language = \App\Language::getLocale();
        $data = [
            'products' => [],
            'page_id' => 3,
            'page' => [
                'meta_title' => $cat['meta_title'] ?? $title,
                'meta_keyword' => $cat['meta_keyword'] ?? "",
                'meta_description' => $cat['meta_description'] ?? ""
            ],
        ];

        $need_trans = true;
        if ($slug == 'hot') {
            $title = "Top 10";
            $data['products'] = Product::take(10)->orderBy('id', 'DESC')->get();
            $data['page_id'] = 2;
        } else {
            $options = [];
            if (!empty($slug) && $slug != 'all') {
                $options['category'] = $slug;
            }
            $need_trans = false;
            $data = Product::getProducts($options);
        }

        $categories = Category::sortPages(
            array_values(
                Translation::getTranslation(
                    $language['id'],
                    'Category',
                    Category::all()->toArray()
                )
            )
        );

        if (!empty($data['products']) && $need_trans) {
            $data['products'] = array_values(Translation::getTranslation($language['id'], 'Product', $data['products']->toArray() ));
        }

        $random_products = array_values(Translation::getTranslation($language['id'], 'Product', Product::inRandomOrder()->take(4)->get()->toArray() ));

        return view('product.collection', array_merge([
            'cms' => \App\Cms::first()->toArray(),
            'cats' => $categories,
            'random_products' => $random_products,
            'recommanded_products' => Product::inRandomOrder()->take(1)->get(),
        ], $data));
    }

}
