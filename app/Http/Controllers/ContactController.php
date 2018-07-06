<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Translation;
use \App\Contact;

class ContactController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index() {
        return view('contact.index');
    }

    public function add() {
        return view('contact.add');
    }

    public function edit($id) {
        $language = \App\Language::getLocale();
        $contact = Translation::getTranslation($language['id'], 'Contact', Contact::find($id)->toArray(), true, $id );
        return view('contact.edit', ['contact' => $contact]);
    }


    public function delete($id=null) {
        $contact = Contact::find($id)->toArray();
        $path = "./img/icons/".$contact['icon'];
        if (file_exists($path) && !empty($contact['icon'])) {
            unlink($path);
        }
        Contact::destroy($id);
        return redirect('/contact');
    }


    public function save(Request $request) {

        $contact = $request->id > 0 ? Contact::find($request->id) : new Contact;
        $contact->status = empty($request->status) ? 0 : 1;
        $contact->type = $request->type;
        $lang = $request->language;

        if ($request->id > 0) {
            //if this was edit then i delete the old translation and product data except images
            $id = $request->id;
            Translation::where('language_id', $lang)
            ->where('model', 'Contact')
            ->where('foreign_key', $id)->delete();

            $path = "./img/icons/".$contact['icon'];
            if (file_exists($path) && (!empty($_FILES['image']['tmp_name']))) {
                unlink($path);
            }
        }

        if ($contact->save()) {
            $id = $contact['id'];
            $trans_fields = Translation::$virtual_fields['Contact'];
            foreach ($trans_fields as $trans_field) {
                Translation::create([
                    'model' => 'Contact',
                    'foreign_key' => $id,
                    'field' => $trans_field,
                    'language_id' => $lang,
                    'value' => $request->$trans_field,
                ]);
            }
            if (!empty($_FILES['image']['tmp_name'])) {
                $filename = time().$_FILES['image']['name'];
                move_uploaded_file($_FILES['image']['tmp_name'], "img/icons/".$filename);
                $contact->icon = $filename;
                $contact->save();
            }
        } else {
            App::abort(500, 'Error');
        }
        return redirect('/contact');
    }

}
