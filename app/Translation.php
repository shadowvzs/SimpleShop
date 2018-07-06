<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Translation extends Model {

    protected $table = 'translations';
    protected $fillable = ['field', 'model', 'language_id', 'value', 'foreign_key'];
    public static $virtual_fields = [
        'Category' => ['name', 'slug', 'description', 'meta_title', 'meta_keyword', 'meta_description'],
        'Product' => ['name', 'slug','description', 'meta_title', 'meta_keyword', 'meta_description'],
        'Language' => ['name'],
        'Page' => ['name', 'content', 'url', 'meta_title', 'meta_keyword', 'meta_description'],
        'Contact' => ['name', 'value'],
        'Color' => ['name'],
    ];

    protected $casts = [
        'id' => 'integer',
        'language_id' => 'integer',
        'foreign_key' => 'integer',
        'status' => 'integer',
    ];

    public static function getTranslation($language, $model, $data=null, $strict=null, $key_id=null) {
        if ($strict && empty($data)) { return []; }

        $translation = self::where('language_id',$language)
        ->where('model',$model);
        if ($key_id) {
            $translation = $translation->where('foreign_key', $key_id);
        }
        $translation = $translation->get()->toArray();
        if ($data) {
            $temp = [];
            if ($key_id) {
                $temp = $data;
                if (empty($translation)) {
                    foreach (self::$virtual_fields[$model] as $field) {
                        $temp[$field] = "";
                    }
                } else {
                    foreach ($translation as $record) {
                        $temp[$record['field']] = $record['value'];
                    }
                }
            } else {
                foreach ($data as $record) {
                    $temp[$record['id']] = $record;
                }

                if (empty($translation)) {
                    foreach ($temp as $id => $data) {
                        foreach (self::$virtual_fields[$model] as $field) {
                            $temp[$id][$field] = "";
                        }
                    }
                } else {
                    foreach ($translation as $record) {
                        $fkey = $record['foreign_key'];
                        if (!empty($temp[$fkey])) {
                            $temp[$fkey][$record['field']] = $record['value'];
                        }
                    }
                }
            }
            $translation = $temp;
        }

        return $translation;
    }

}
