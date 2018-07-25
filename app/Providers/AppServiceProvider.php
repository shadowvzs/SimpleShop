<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider {

    public function boot() {
        // if we dont check if running console then this method give error
        // because also running during migration where table still maybe not exist
        if (!$this->app->runningInConsole()) {
            view()->composer('*', function ($view) {
                $languages = array_values(\App\Language::all()->toArray());
                $available_lang = [];

                $get_default_lang = false;
                if (!empty(\Session::get('lang'))) {
                    $get_default_lang = \Session::get('lang');
                }

                foreach ($languages as $lang) {
                    if ($lang['status'] == 1) {
                        array_push($available_lang, $lang);
                        if ($get_default_lang !== false && $lang['id'] == $get_default_lang) {
                            $default_lang = $lang;
                        }
                    }
                }

                if (empty($default_lang)) {
                    $default_lang = $available_lang[0];
                }

                $language = $default_lang;
                \Session::put('lang', $language['id']);
                \Session::put('lang_code', $language['code']);

                $pages = array_values(\App\Page::sortPages(\App\Translation::getTranslation($language['id'], 'Page', \App\Page::all()->toArray())));
                $menus = array_filter($pages, function($p) { return ($p['type'] != 2 && $p['status'] == 1); });
                $contacts = \App\Contact::sortContacts($language['id']);
                $categories = \App\Translation::getTranslation($language['id'], 'Category', \App\Category::all()->toArray());
                $available_colors = \App\Translation::getTranslation($language['id'], 'Color', \App\Color::where('status', 1)->get()->toArray());
                $available_sizes = \App\Size::where('status', 1)->get()->toArray();
                $cms =  \App\Cms::first()->toArray();
                $sortby = [
                    ['created_at-ASC', 'default.order_date', 'default.order_asc'],
                    ['created_at-DESC', 'default.order_date', 'default.order_desc'],
                    ['name-ASC', 'default.order_name', 'default.order_asc'],
                    ['name-DESC', 'default.order_name', 'default.order_desc'],
                    ['price-ASC', 'default.order_price', 'default.order_asc'],
                    ['price-DESC', 'default.order_price', 'default.order_desc'],
                ];

                //this code will be executed when the view is composed, so session will be available
                $view->with('languages', $languages )
                    ->with('available_lang', $available_lang )
                    ->with('available_colors', $available_colors )
                    ->with('available_sizes', $available_sizes )
                    ->with('language', $language )
                    ->with('pages', $pages )
                    ->with('menus', $menus )
                    ->with('contacts', $contacts )
                    ->with('categories', $categories )
                    ->with('orderby_list', $sortby)
                    ->with('cms', $cms )
                    ->with('page_limits', [10, 25, 50, 100] );
            });
        }
    }

    public function register() {
        //
    }
}
