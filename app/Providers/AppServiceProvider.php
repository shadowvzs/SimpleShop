<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
//use Illuminate\Support\Facades\Session;

class AppServiceProvider extends ServiceProvider {

    public function boot() {
  		// if we dont check if running console then this method give error
		// because also running during migration where table still maybe not exist
  		if (!$this->app->runningInConsole()) {
			view()->composer('*', function ($view) {
				$languages = \App\Language::all()->toArray();
				$available_lang = [];
			
				foreach ($languages as $lang) {
					if ($lang['status'] == 1) {
						array_push($available_lang, $lang);
					}
					if ($lang['id'] == \Session::get('lang')) {
						$default_lang = $lang;
					}
				}
				
				if (empty($default_lang)) { 
					$default_lang = $available_lang[0];
				}
				$language = $default_lang;
				\Session::put('lang', $language['id']);
				\Session::put('lang_code', $language['code']);

				$pages = array_values(\App\Page::sortPages(\App\Translation::getTranslation($language['id'], 'Page', \App\Page::all()->toArray())));
				$contacts = \App\Contact::sortContacts($language['id']);
				$categories = \App\Translation::getTranslation($language['id'], 'Category', \App\Category::all()->toArray());
				$cms =  \App\Cms::first()->toArray();
				$cms['place'] = json_decode($cms['decor_option'])->place;
				//dd($cms['place']);
				//this code will be executed when the view is composed, so session will be available
				$view->with('languages', $languages )
					->with('available_lang', $available_lang)
					->with('language', $language )
					->with('pages', $pages )
					->with('contacts', $contacts )
					->with('categories', $categories )
					->with('cms', $cms );
			});
  		 }
    }

    public function register() {
        //
    }
}
