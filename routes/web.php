<?php

Auth::routes();

Route::get('/dashboard', 'DashboardController@index');
Route::get('/dashboard/view/{id}', 'DashboardController@order_view');
Route::get('/dashboard/language/{id}/{code}', 'LanguageController@adminChangeLanguage');

Route::post('/order/delete', 'DashboardController@order_delete');

Route::get('/product', 'ProductController@index');
Route::get('/product/add', 'ProductController@add');
Route::get('/product/delete/{id}', 'ProductController@delete');
Route::get('/product/delete_image/{id}', 'ProductController@delete_image');
Route::get('/product/edit/{id}', 'ProductController@edit');
Route::post('/product/save', 'ProductController@save');

Route::get('/color', 'ColorController@index');
Route::get('/color/add', 'ColorController@add');
Route::get('/color/delete/{id}', 'ColorController@delete');
Route::get('/color/edit/{id}', 'ColorController@edit');
Route::post('/color/save', 'ColorController@save');

Route::get('/size', 'SizeController@index');
Route::get('/size/add', 'SizeController@add');
Route::get('/size/delete/{id}', 'SizeController@delete');
Route::get('/size/edit/{id}', 'SizeController@edit');
Route::post('/size/save', 'SizeController@save');

Route::get('/category', 'CategoryController@index');
Route::get('/category/add', 'CategoryController@add');
Route::get('/category/delete/{id}', 'CategoryController@delete');
Route::get('/category/edit/{id}', 'CategoryController@edit');
Route::post('/category/save', 'CategoryController@save');

Route::get('/page', 'PageController@index');
Route::get('/page/add', 'PageController@add');
Route::get('/page/delete/{id}', 'PageController@delete');
Route::get('/page/edit/{id}', 'PageController@edit');
Route::post('/page/save', 'PageController@save');

Route::get('/language', 'LanguageController@index');
Route::get('/language/add', 'LanguageController@add');
Route::get('/language/delete/{id}', 'LanguageController@delete');
Route::get('/language/edit/{id}', 'LanguageController@edit');
Route::get('/language/translation', 'LanguageController@translation');
Route::post('/language/translation', 'LanguageController@update_translation');
Route::post('/language/save', 'LanguageController@save');
Route::get('/language/{id}', 'LanguageController@changeLanguage');

Route::get('/slide', 'SlideController@index');
Route::get('/slide/add', 'SlideController@add');
Route::get('/slide/move/{id}/{direction}', 'SlideController@move');
Route::get('/slide/delete/{id}', 'SlideController@delete');
Route::post('/slide/save', 'SlideController@save');

Route::get ('/contact', 'ContactController@index');
Route::get ('/contact/add', 'ContactController@add');
Route::get ('/contact/delete/{id}', 'ContactController@delete');
Route::get ('/contact/edit/{id}', 'ContactController@edit');
Route::post('/contact/save', 'ContactController@save');

Route::get ('/setting', 'CmsController@index');
Route::post('/setting/save', 'CmsController@save');

Route::get('/cart', 'CartController@index');
Route::post('/cart/add', 'CartController@add');
Route::get('/cart/delete/{id}', 'CartController@delete');
Route::post('/cart/order', 'CartController@order');

Route::get('/prod/{slug}', 'ProductController@view');
Route::get('/collection/{slug}', 'ProductController@collection');

Route::get('/test', 'CartController@order');
Route::get('/', 'PageController@getPage');

Route::get('{slug?}', 'PageController@getPage');

/*
Route::get('{slug}', [
    'uses' => 'PageController@getPage'
])->where('slug', '([A-Za-z0-9\-\/]+)');
*/
