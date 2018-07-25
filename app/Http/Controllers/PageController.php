<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Page;
use \App\Translation;
use Illuminate\Support\Facades\Session;

class PageController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth', ['except' => ['getPage']]);
    }

    public function getPage($slug="home") {

        $language = \App\Language::getLocale();
        $slides = false;
        $page = Translation::where('field', 'url')
                    ->where('value', '/'.strtolower($slug))
                    ->where('model', 'Page')
                    ->first();
        if (empty($page)) { abort(404); }
        $page = Page::find($page->foreign_key);
        $cms = \App\Cms::first()->toArray();
        $products = array_values(Translation::getTranslation($language['id'], 'Product', \App\Product::take(10)->orderBy('id', 'DESC')->get()->toArray()));
        $page = array_values(Translation::getTranslation($language['id'], 'Page', [$page]))[0];
        $page_id = $page['id'];
        $ASSET_PATH = asset('img');
        $CMS_PATH = $ASSET_PATH.'/cms/';
        $PROD_PATH = $ASSET_PATH.'/products/';

 		if (!empty($page['content'])) {
            preg_match('/#slide#/', $page['content'], $matches, PREG_OFFSET_CAPTURE);
            if (count($matches) > 0) {
                $slides = \App\Slide::orderby('order_id', 'asc')->get()->toArray();
            }
            preg_match('/#recommend#/', $page['content'], $matches, PREG_OFFSET_CAPTURE);
            if (count($matches) > 0) {
                $recommend = \App\Slide::orderby('order_id', 'asc')->get()->toArray();
            }
            $search  = array(
                '#slide#', '#recommend#',
            );
            $replace = array(
                ''
            );
  			$page['content'] = str_replace($search, $replace, nl2br($page['content']));
  			for ($i=10;$i>=0;$i--) {
                $str = '#product*'.$i.'#';
                if (preg_match('/'."\#product\*$i\#".'/im', $page['content'])) {
                    $page['content'] = str_replace($str, '', $page['content']);
                } else {
                    unset($products[$i]);
                }
                //$page['content'] = str_replace('#product*'.$i.'#', '<div class="col-12 col-sm-6 col-md-4 col-lg-3"><a href="/prod/'.($products[$i]['slug'] ?? "").'" title="'.$products[$i]['name'].'" class="prod_thumbnail"><img src="'.$PROD_PATH.$products[$i]['main_image'].'" alt="Cover"></a></div>', $page['content']);
                //$page['content'] = str_replace('#product*'.$i.'#', '<div class="col-12 col-sm-6 col-md-4 col-lg-3"><a href="/prod/'.($products[$i]['slug'] ?? "").'" title="'.$products[$i]['name'].'" class="prod_thumbnail"><img src="'.$PROD_PATH.$products[$i]['main_image'].'" alt="Cover"></a></div>', $page['content']);
  			}
		} else {
			 $page['content'] = "";
		}

        return view('page.view',[
            'page' => $page,
            'cms' => $cms,
            'products' => $products,
            'slides' => $slides,
            'page_id' => $page_id
        ]);
    }

    public function index() {
        $language = \App\Language::getLocale();
        $this->frontend_pages = Translation::getTranslation($language['id'], 'Page', Page::where('type', '<>', 2)->get()->toArray());
        return view('page.index',['frontend_pages' => $this->frontend_pages]);
    }

    public function add() {
        $language = \App\Language::getLocale();
        $this->frontend_pages = Translation::getTranslation($language['id'], 'Page', Page::where('type', '<>', 2)->get()->toArray());
        return view('page.add', ['frontend_pages' => $this->frontend_pages]);
      }

    public function edit($id) {
        $language = \App\Language::getLocale();
        $this->frontend_pages = Translation::getTranslation($language['id'], 'Page', Page::where('type', '<>', 2)->get()->toArray());
        $page = Translation::getTranslation($language['id'], 'Page', Page::find($id)->toArray(), true, $id );
        return view('page.edit', ['page' => $page, 'frontend_pages' => $this->frontend_pages]);
    }

    public function delete($id=null) {
        Page::destroy($id);
        Translation::where('model', 'Page')->where('foreign_key', $id)->delete();
        return redirect('/page');
    }

    public function save(Request $request) {
        $page = $request->id > 0 ? Page::find($request->id) : new Page;
        $page->status = empty($request->status) ? 0 : 1;
        $page->type = $request->type;
        $page->parent_id = $request->parent_id;
        $page->category_id = $request->category;
        $lang = $request->language;

        if (empty($request->url)) {
            $name = $request->name;
            $request->url = '/'.(Page::slugger($name));
        }

        if ($page->save()) {
          $id = $page['id'];
          Translation::where('language_id', $lang)
                     ->where('model', 'Page')
                     ->where('foreign_key', $id)->delete();
          $trans_fields = Translation::$virtual_fields['Page'];

          foreach ($trans_fields as $trans_field) {
              Translation::create([
                  'model' => 'Page',
                  'foreign_key' => $id,
                  'field' => $trans_field,
                  'language_id' => $lang,
                  'value' => $request->$trans_field,
              ]);
          }

        } else {
          App::abort(500, 'Error');
        }
        return redirect('/page');
    }

}
