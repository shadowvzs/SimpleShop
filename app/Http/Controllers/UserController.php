<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;

class UserController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    public function logout() {
        \Auth::logout();
		return redirect('/home');
    }	

    public function saveUser(Request $request) {
		$auth_user = \Auth::user();
		$new_pass = Input::get('new_pass');
		$new_pass2 = Input::get('new_pass2');

		if ($new_pass != $new_pass2 || strlen($new_pass) < 6)  {
			session(['status' => 'The passswords must match and minimum 6 character!']);
			return back();
		}
		if (!empty($auth_user)) {
			$mysql_user = \App\User::find($auth_user->id);	
			if (!($mysql_user && Hash::check(Input::get('old_pass'), $mysql_user->password))) {
				session(['status' => 'Wrong old password!']);
				return back();
			}
			$mysql_user->email = $request->email;
			$mysql_user->password = Hash::make($new_pass);
			$mysql_user->save();
			session(['status' => 'User data updated, you must login again!']);
			return back();
		}
		/*
		$validate_admin = DB::table('administrators')
                            ->select('username')
                            ->where('username', Input::get('admin_username'))
                            ->first();

if ($validate_admin && Hash::check(Input::get('admin_password'), $validate_admin->password)) {
  // here you know data is valid
}
		$request
        return back();
		*/
    }
}
