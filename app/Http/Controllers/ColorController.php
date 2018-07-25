<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Translation;
use \App\Color;

class ColorController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index() {
        $language = \App\Language::getLocale();
        $colors = Translation::getTranslation($language['id'], 'Color', Color::all()->toArray());
        return view('color.index',['colors' => $colors]);
    }

    public function add() {
        return view('color.add');
    }

    public function edit($id) {
        $language = \App\Language::getLocale();
        $color = Translation::getTranslation($language['id'], 'Color', Color::find($id)->toArray(), true, $id );
        return view('color.edit', ['color' => $color]);
    }


    public function delete($id=null) {
        $color = Color::find($id);
        if (empty($color)) {
            return redirect('/color');
        }
        Translation::where('model', 'Color')->where('foreign_key', $id)->delete();
        $path = "./img/colors/".$color['image'];
        if (file_exists($path)) {
            unlink($path);
        }
        Color::destroy($id);
        return redirect('/color');
    }

    public function save(Request $request) {

        $color = $request->id > 0 ? Color::find($request->id) : new Color;
        $color->status = empty($request->status) ? 0 : 1;
        $lang = $request->language;

        if ($request->id > 0) {
            //if this was edit then i delete the old translation and product data except images
            $id = $request->id;
            Translation::where('language_id', $lang)
            ->where('model', 'Color')
            ->where('foreign_key', $id)->delete();

            $path = "./img/colors/".$color['image'];
            if (file_exists($path) && (!empty($_FILES['image']['tmp_name']))) {
                unlink($path);
            }
        }

        if ($color->save()) {
            $id = $color['id'];
            $trans_fields = Translation::$virtual_fields['Color'];
            foreach ($trans_fields as $trans_field) {
                if ($trans_field == "slug") {
                    $value = $color->getSlug($request->name);
                }
                Translation::create([
                    'model' => 'Color',
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
        return redirect('/color');
    }

}
