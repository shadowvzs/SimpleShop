<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Size;

class SizeController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }


    public function index() {
      $sizes = Size::all()->toArray();
      return view('size.index',['sizes' => $sizes]);
    }

    public function add() {
      return view('size.add');
    }

    public function edit($id) {
      return view('size.edit', ['size' => Size::find($id)]);
    }


    public function delete($id=null) {
      Size::destroy($id);
      return redirect('/size');
    }


    public function save(Request $request) {

      $size = $request->id > 0 ? Size::find($request->id) : new Size;
      $size->status = empty($request->status) ? 0 : 1;
      $size->name = $request->name;
      $lang = $request->language;

      if (!$size->save()) {
        App::abort(500, 'Error');
      }
      return redirect('/size');
    }

}
