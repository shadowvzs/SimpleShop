<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use \App\Cms;

class CmsController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

     public function index() {
       $cms = Cms::first()->toArray();
       $decor_option = json_decode($cms['decor_option']);
       $user = \App\User::first()->toArray();
       return view('cms.index', ['user' => $user, 'cms' => $cms, 'decor_option' => $decor_option]);
     }

     public function save(Request $request) {
       $cms = Cms::first();
       $decor_option = json_decode($cms['decor_option']);
       $folder = "img/cms/";
       $cms->name = $request->name;
       $cms->map = $request->map;
       $cms->currency = $request->currency;
       $cms->order_mail = $request->order_mail;
       $cms->footer_social = $request->footer_social ? 1 : 0;
       $cms->footer_map = $request->footer_map ? 1 : 0;
       $cms->footer_contact = $request->footer_contact ? 1 : 0;

       $images = ['cover', 'logo', 'decoration'];
       $imageFiles = [];
       foreach ($images as $image) {
         if (!empty($_FILES[$image]['tmp_name'])) {
             $newFileName = uniqid().'_'.time().'_'.$_FILES[$image]['name'];
             array_push($imageFiles , [
               $folder,
               $cms->$image,
               $_FILES[$image]['tmp_name'],
               $newFileName
             ]);
            $cms->$image = $newFileName;
         }
       }

       $places = ['top', 'left', 'right', 'bottom'];

       foreach ($places as $place) {
          $fieldName = "decor_".$place;
          $decor_option->place->$place = !empty($request->$fieldName);
       }
	
		$cms['decor_option'] = json_encode($decor_option);
		
      if ($cms->save()) {
            foreach ($imageFiles as $imageFile) {
                if (file_exists('./'.$imageFile[0].$imageFile[1])){
                    unlink('./'.$imageFile[0].$imageFile[1]);
                }
                move_uploaded_file($imageFile[2], $imageFile[0].$imageFile[3]);
            }
            session(['status' => 'Everything was saved!']);
      } else {
          App::abort(500, 'Error');
      }
      return redirect('/setting');
    }
}
