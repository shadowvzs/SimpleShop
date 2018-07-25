<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use \App\Language;

class LanguageController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth', ['except' => ['changeLanguage']]);
    }

    public function changeLanguage($id) {

        $language = Language::where('id', intval($id))->where('status', 1)->first()->toArray();

        if (empty($language)) {
            $language = Language::where('status', 1)->first()->toArray();
        }

        Session::put('lang', $language['id']);
        Session::put('lang_code', $language['code']);

        return json_encode([
          'success' => true,
          'code' => $language['code']
        ]);
    }

    public function adminChangeLanguage($id, $code) {

        Session::put('lang', $id);
        Session::put('lang_code', $code);

        return back();
    }

    public function index() {
          return view('language.index');
    }

    public function add() {
        return view('language.add');
    }

    public function translation() {
        $languages = \App\Language::all()->toArray();
        $po_strings = [];
        $LANG_FOLDER_PATH = resource_path('lang').'/';

        foreach($languages as $language) {
            $code = strtolower($language['code']);
            $LANG_DIR_PATH = $LANG_FOLDER_PATH.$code;
            $LANG_FILE_PATH = $LANG_DIR_PATH.'/default.php';
            $handle = fopen($LANG_FILE_PATH, "r");
            $text = fread($handle,filesize($LANG_FILE_PATH));
            fclose($handle);
            if (preg_match("/\[[^\]]*\]/", $text, $matches)) {
                $translation = get_object_vars(json_decode(str_replace(array("'", " => ", '",]', '["', '"]'), array('"', ":", '"}', '{"', '"}'), preg_replace("/(\r|\n|\t)/", "", $matches[0]))));
                foreach ($translation as $key => $value) {
                    if (empty($po_strings[$key])) {
                        $po_strings[$key] = [];
                    }
                    $po_strings[$key][$code] = $value;

                }
            }
        }
        return view('language.translation', [
            'po_strings' => $po_strings
        ]);
    }

    public function update_translation(Request $request) {
        $LANG_FOLDER_PATH = resource_path('lang').'/';
        $translations = $request->key;
        foreach ($translations as $language => $translation) {
            $LANG_FILE_PATH = $LANG_FOLDER_PATH.strtolower($language).'/default.php';
            $translation_data = "<?php  \n\treturn [\n";
            foreach ($translation as $key => $value) {
                $translation_data .= "\t\t'".$key."' => '$value',\n";
            }
            $translation_data .= "];";
            $handle = fopen($LANG_FILE_PATH, "w");
            $text = fwrite($handle,$translation_data);
            fclose($handle);
        }
        return redirect('/language');
    }

    public function edit($id) {
        $lang = Language::find($id)->toArray();
        return view('language.edit', ['lang' => $lang]);
    }


    public function delete($id=null) {
      Language::destroy($id);
      \App\Translation::where('language_id', $id)->delete();
      return redirect('/language');
    }


    public function save(Request $request) {

      $lang = $request->id > 0 ? Language::find($request->id) : new Language;
      $lang->status = empty($request->status) ? 0 : 1;
      $lang->name = $request->name;
      $lang->code = $request->code;
      $LANG_FOLDER_PATH = "../resources/lang/";
      $LANG_DIR_PATH = $LANG_FOLDER_PATH.strtolower($lang->code);
      $LANG_FILE_PATH = $LANG_DIR_PATH.'/default.php';
      if (!file_exists($LANG_DIR_PATH)) {
          mkdir($LANG_DIR_PATH, 0777);
          if (!file_exists($LANG_FILE_PATH)) {
              $DEFAULT_TEXT = "<?php return [];";
              file_put_contents($LANG_FILE_PATH, $DEFAULT_TEXT);
          }
      }

      if ($request->id > 0) {
        $path = "./img/flags/".$lang['flag'];
        if (file_exists($path) && (!empty($_FILES['image']['tmp_name']))) {
          unlink($path);
        }
      }

      if ($lang->save()) {
          $id = $lang['id'];
          if (!empty($_FILES['image']['tmp_name'])) {
            $filename = time().$_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], "img/flags/".$filename);
            $lang->flag = $filename;
            $lang->save();
          }
      } else {
        App::abort(500, 'Error');
      }
      return redirect('/language');
    }

}
