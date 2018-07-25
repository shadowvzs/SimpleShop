<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cms extends Model {
    protected $table = 'cms';
	protected $casts = [
		'id' => 'integer',
		'logo_option' => 'integer',
		'maintance' => 'integer',
	];
	
    public static function getSettings() {
        $newArray = [];
        $cms = Cms::all()->toArray();
        foreach($cms as $setting) {
          $newArray[$setting['field']] = [
              "value" => $setting['value'],
              "option" => $setting['option'] ? json_decode($setting['option']) : false,
          ];
        }
        return $newArray;
    }

}
