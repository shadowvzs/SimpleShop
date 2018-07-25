<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
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
			['HOME', 1, 0, 0, '#cover#<br><div class="d-flex justify-content-around flex-row flex-wrap">#product*1# #product*1# #product*1# #product*1#</div>', 0, '/home','PAGINA PRINCIPALA','FOOLDAL',0],
			['NEW IN', 2, 0, 0, '', 1, "/collection/hot",'NOUTATI','UJDONSAGOK',0], 
			['COLLECTION', 3, 0, 0, '', 1, '/collection/all','COLECTIE', 'KATEGORIAK',0], 
			['EVENING', 4, 3, 0, '', 1, '/collection/evening','DE SEARE', 'ESTELYI',1], 
			['DATE NIGHT', 5, 3, 0, '', 1, '/collection/date_night', 'INTALNIRE', 'RANDI',2], 
			['(BRIDAL)', 6, 3, 0, '', 1, '/collection/bridal','DE NUNTA','ESKUVOI',3], 
			['ABOUT', 7, 0, 0, "<div class='about_box leather-bg'><h3>Brand manifesto Mood'On</h3>

         Welcome everyone! We're Mood'On and we've decided to redefine the way evening gowns are looked upon, transforming them from simple and must-have accessories for special events, cocktail parties and galas, into genuine states of mind aimed to suggest and emanate elegance and refinement. Working with passion and skill, exclusively with high-quality textures, created from natural silk fibers, we made sure that we manage to offer, those who decide to wear our creations, a unique and unforgettable experience, after all, a night gown should be a declaration of love to ourselves, don't you think, without forgetting about comfort, as attitude, the ingenious and honest hart-to-pretend smile, the sparkle, all emanate from us.
Evermore.

         Bohemian spirits, however, extremely down to earth when it comes to the reality of modern day fashion, we sculpted evening gowns  able to bring out the best of all silhouettes, concentrating on elegant creations with eminently feminine lines, to celebrate, as it should, the fair sex. All  Mood'On designs from our site equal uniqueness and exclusivity, the gowns of our brand are, entirely, the fruit of our hard work, and also a fabulous mix of classical and modern, in order to be able to offer that unique experience, so desired nowadays, in a world where originality slowly and surely seems to lose ground.

           We didn't disregard the importance of establishing a special relationship with you either, we consider, that every member of our community is a member of the big Mood'On family, that's the reason we took the commitment to surprise you every time, not only through the diversity of our actual collection (an the rest of the ones that will come), but also through small signs of gratitude, in forms of gifts, personalized surprises, as we like to call them which you'll receive in every package, after placing and order. We took into consideration the need of customers for quality guarantee, as a result, we offer returns, regardless of the motive, in a term of 7 days from the delivery of the package, without requesting additional information, offering for analysis and consultation the table of measurements and size based on which we operate.

             Finally, we don't have anything else left to do, than to honestly thank you for the interest shown to our products and we invite you into the little corner of our universe, of Heaven, where you will always be more than just clients and where elegance is a state of mind. Ours. Yours, Everyone's.
<br><br></div>", 0, '/about','DESPR NOI','ROLUNK',0], 
			['PRESS', 8, 0, 0, '', 0, '/press','PRES','NEM TUDOM',0], 
			
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
					//'url' => $page_data[6],
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
