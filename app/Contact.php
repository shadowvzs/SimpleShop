<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model {
    protected $table = 'contacts';
	protected $casts = [
		'id' => 'integer',
		'status' => 'integer',
		'type' => 'integer',
	];
	
    public static function sortContacts ($language) {
      $all_contact = self::all()->toArray();
      $contacts = \App\Translation::getTranslation($language, 'Contact', $all_contact);
      $type = ['Contact', 'SocialLink', 'Admin'];
      $data = [];
      foreach ($contacts as $contact) {
        $contact_type = $contact['type'];
        $sel_type = $type[$contact_type];
        if (!isset($sel_type)) { continue; }
        if (!isset($data[$sel_type])) { $data[$sel_type] = []; }
        array_push($data[$sel_type], $contact);
      }
      return $data;
    }

}
