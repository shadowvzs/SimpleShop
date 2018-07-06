<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{

    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->unsignedBigInteger('id')->autoIncrement();
			$table->unsignedInteger('parent_id')->default('0');
			$table->unsignedInteger('category_id')->default('0');
			$table->unsignedInteger('order')->default('0');
			$table->unsignedTinyInteger('status')->default('1')->comment = "0=inactive, 1=active";
			$table->unsignedTinyInteger('type')->default('0')->comment = "0=static, 1=productCategory, 2=admin";
			$table->unsignedTinyInteger('auth')->default('0')->comment = "0=public, 1=admin";
			$table->unsignedTinyInteger('show_decor')->default('1');
			$table->timestamps();
			$table->engine = 'InnoDB';			
        });
		
		$today = date("Y-m-d H:i:s");
		$default_lang = 1;
		
		$data = [
			['DASHBOARD', 9, 0, 1, '', 2, '/dashboard', 'DASHBOARD', 'DASHBOARD',0], 
			['PRODUCT', 10, 0, 1, '', 2, '/product', 'PRODUSE', 'ARU',0], 
			['ADD', 11, 10, 1, '', 2, '/product/add', 'ADAUGARE', 'HOZZAADAS',0], 
			['LIST', 12, 10, 1, '', 2, '/product', 'LISTA', 'LISTA',0], 
			['COLOR', 13, 0, 1, '', 2, '/color', 'CULOARE', 'SZIN',0], 
			['ADD', 14, 13, 1, '', 2, '/color/add', 'ADAUGARE', 'HOZZAADAS',0], 
			['LIST', 15, 13, 1, '', 2, '/color', 'LISTA', 'LISTA',0], 
			['SIZE', 16, 0, 1, '', 2, '/size', 'MARIME', 'MERET',0], 
			['ADD', 17, 16, 1, '', 2, '/size/add', 'ADAUGARE', 'HOZZAADAS',0], 
			['LIST', 18, 16, 1, '', 2, '/size', 'LISTA', 'LISTA',0], 
			['CATEGORY', 19, 0, 1, '', 2, '/category','CATEGORIE','KATEGORIAK',0], 
			['ADD', 20, 19, 1, '', 2, '/category/add', 'ADAUGARE', 'HOZZAADAS',0], 
			['LIST', 21, 19, 1, '', 2, '/category', 'LISTA', 'LISTA',0], 
			['PAGES', 22, 0, 1, '', 2, '/page','PAGINA','OLDAL',0], 
			['ADD', 23, 22, 1, '', 2, '/page/add', 'ADAUGARE', 'HOZZAADAS',0], 
			['LIST', 24, 22, 1, '', 2, '/page', 'LISTA', 'LISTA',0], 
			['LANGUAGE', 25, 0, 1, '', 2, '/language','LIMBA','NYELV',0], 
			['ADD', 26, 25, 1, '', 2, '/language/add', 'ADAUGARE', 'HOZZAADAS',0], 
			['LIST', 27, 25, 1, '', 2, '/language', 'LISTA', 'LISTA',0], 
			['TRANSLATE', 28, 25, 1, '', 2, '/language/translation', 'TRADUCE', 'FORDITAS',0], 
			['CONTACT', 29, 0, 1, '', 2, '/contact','CONTACT', 'ELERHETOSEG',0], 
			['ADD', 30, 29, 1, '', 2, '/contact/add', 'ADAUGARE', 'HOZZAADAS',0], 
			['LIST', 31, 29, 1, '', 2, '/contact', 'LISTA', 'LISTA',0], 
			['SLIDE', 32, 0, 1, '', 2, '/slide','SLIDE', 'SLIDE',0], 
			['ADD', 33, 32, 1, '', 2, '/slide/add', 'ADAUGARE', 'HOZZAADAS',0], 
			['LIST', 34, 32, 1, '', 2, '/slide', 'LISTA', 'LISTA',0], 
			['SETTINGS', 35, 0, 1, '', 2, '/setting','SETARE','BEALLITASOK',0], 
			['LOGOUT', 36, 0, 1, '', 2, '/logout','IESIRE','KIJELENTKEZES',0], 
		];

			
		foreach ($data as $page_data) {
			\DB::table('pages')->insert(
				[
					'id' => $page_data[1],
					'parent_id' => $page_data[2],
					'category_id' => $page_data[9],
					'type' => $page_data[5],
					'order' => $page_data[1],
					'auth' => $page_data[3],
					'created_at' => $today,
					'updated_at' => $today,
				]
			);
			for($i=1;$i<4;$i++) {
			
				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Page',
						'foreign_key' => $page_data[1],
						'field' => 'url',
						'value' => $page_data[6],
						'created_at' => $today,
						'updated_at' => $today,
					]
				);		
				
			
				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Page',
						'foreign_key' => $page_data[1],
						'field' => 'content',
						'value' => $page_data[4],
						'created_at' => $today,
						'updated_at' => $today,
					]
				);	
				
				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Page',
						'foreign_key' => $page_data[1],
						'field' => 'meta_title',
						'value' => '',
						'created_at' => $today,
						'updated_at' => $today,
					]
				);		
				
				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Page',
						'foreign_key' => $page_data[1],
						'field' => 'meta_description',
						'value' => '',
						'created_at' => $today,
						'updated_at' => $today,
					]
				);	
				
				\DB::table('translations')->insert(
					[
						'language_id' => $i,
						'model' => 'Page',
						'foreign_key' => $page_data[1],
						'field' => 'meta_keyword',
						'value' => '',
						'created_at' => $today,
						'updated_at' => $today,
					]
				);	
			}	
			
			\DB::table('translations')->insert(
				[
					'language_id' => 1,
					'model' => 'Page',
					'foreign_key' => $page_data[1],
					'field' => 'name',
					'value' => $page_data[0],
					'created_at' => $today,
					'updated_at' => $today,
				]
			);
				
			\DB::table('translations')->insert(
				[
					'language_id' => 2,
					'model' => 'Page',
					'foreign_key' => $page_data[1],
					'field' => 'name',
					'value' => $page_data[7],
					'created_at' => $today,
					'updated_at' => $today,
				]
			);			
			
			\DB::table('translations')->insert(
				[
					'language_id' => 3,
					'model' => 'Page',
					'foreign_key' => $page_data[1],
					'field' => 'name',
					'value' => $page_data[8],
					'created_at' => $today,
					'updated_at' => $today,
				]
			);				
		}

    }

	
    public function down()
    {
        Schema::dropIfExists('pages');
    }
}
