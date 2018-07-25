<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Category;
use \App\Translation;

class CategoryController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index() {
        // we already have categories in AppServiceProvider
        //$categories = Translation::getTranslation($this->language, 'Category', Category::all()->toArray());
        //return view('category.index',['categories' => $categories]);
        return view('category.index');
    }

    public function add() {
        return view('category.add');
    }

    public function edit($id) {
        $language = \App\Language::getLocale();
        $category = Translation::getTranslation($language['id'], 'Category', Category::find($id)->toArray(), true, $id );
        return view('category.edit', ['category' => $category]);
    }

    public function delete($id=null) {
        Category::destroy($id);
        Translation::where('model', 'Category')->where('foreign_key', $id)->delete();
        return redirect('/category');
    }

    public function save(Request $request) {
        $category = $request->id > 0 ? Category::find($request->id) : new Category;
        $category->status = empty($request->status) ? 0 : 1;
        $category->parent_id = $request->parent_id;
        $lang = $request->language;

        if ($category->save()) {
            $id = $category['id'];
            Translation::where('language_id', $lang)
            ->where('model', 'Category')
            ->where('foreign_key', $id)->delete();
            $trans_fields = Translation::$virtual_fields['Category'];
            $request->slug = Category::slug($request->name);
            foreach ($trans_fields as $trans_field) {
                Translation::create([
                    'model' => 'Category',
                    'foreign_key' => $id,
                    'field' => $trans_field,
                    'language_id' => $lang,
                    'value' => $request->$trans_field,
                ]);
            }
            if (!empty($_FILES['image']['tmp_name'])) {
                $filename = time().$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "img/colors/".$filename);
                $color->image = $filename;
                $color->save();
            }
        } else {
            App::abort(500, 'Error');
        }
        return redirect('/category');
    }

}
