<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Language extends Model {
    protected $table = 'languages';
	
	protected $casts = [
		'id' => 'integer',
		'status' => 'integer',
	];
	
    public static function getLocale() {
        $lang_id = Session::get('lang');
        $lang_code = Session::get('lang_code');
		if (empty($lang_id)) {
			$language = \App\Language::where('status', 1)->first()->toArray();
			$lang_id = $language['id'];
			$lang_code = $language['code'];
		}
        \App::setLocale($lang_code);
        return ['id' => $lang_id, 'code' => $lang_code];
    }
}
