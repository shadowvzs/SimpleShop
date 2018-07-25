<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Translation;
use \App\Slide;

class SlideController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }


    public function index() {
        $language = \App\Language::getLocale();
        $slides = Slide::orderby('order_id', 'asc')->get()->toArray();
        return view('slide.index',['slides' => $slides]);
    }

    public function add() {
        return view('slide.add');
    }

    public function move($id=null, $direction=null) {
        if ($id && ($direction == "up" || $direction == "down")) {
            $slide = Slide::find($id);
            if (!empty($slide['order_id'])) {
                $order_id =   $slide['order_id'];
                $last = Slide::orderby('order_id', 'desc')->first();
                $last_id = $last['order_id'];
                if (($order_id < 2 && $direction == "up") || (($order_id > $last_id-1) && $direction == "down")) {
                    return back();
                }

                $next = Slide::where('order_id', $order_id + ($direction == "down" ? 1 : -1))->first();

                $tmp = $next['order_id'];
                $next->order_id = $slide->order_id;
                $next->save();
                $slide->order_id = $tmp;
                $slide->save();
            }
        }
        return back();
    }

    public function delete($id=null) {
      $slide = Slide::find($id);
      if (!empty($slide['image'])) {
          $path = './img/slides/'.$slide['image'];
          if (file_exists($path)) {
              unlink($path);
          }
      }

      \DB::update('UPDATE slides SET order_id=ifnull(order_id,0) -1 WHERE order_id > '.$slide->order_id);
      Slide::destroy($id);
      return back();
    }


    public function save(Request $request) {

      if (!empty($_FILES['image'])) {
          $order = Slide::orderby('order_id', 'desc')->first();
          $order_id = empty($order) ? 1 : $order['order_id'] + 1;
          foreach($_FILES['image']['tmp_name'] as $i => $temp_file) {
              if (empty($temp_file)) { continue; }
              $filename = time().$_FILES['image']['name'][$i];
              move_uploaded_file($temp_file, "img/slides/".$filename);
              Slide::create([
                  'image' => $filename,
                  'order_id' => $order_id,
              ]);
              $order_id++;
          }
      }

      return redirect('/slide');
    }

}
