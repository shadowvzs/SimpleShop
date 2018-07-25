<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Translation;
use \App\Image;
use \App\Size;
use \App\Color;
use \App\Product;
use Illuminate\Support\Facades\Session;
use App\Mail\MailSender;
use Illuminate\Support\Facades\Mail;

class CartController extends Controller {

    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $cart_products = Session::get('cart');
        $language = \App\Language::getLocale();

        if (empty($cart_products)) {
            $products = [];
        } else {
            $products = $cart_products;
        }
        $response = [
            'success' => true,
            'items' => $products,
        ];
        echo(json_encode($response));
    }

    public function add(Request $request) {
        $prod = json_decode($request->prod);
        $status = false;
        $response = [];
        $language = \App\Language::getLocale();

        if (!empty($prod)) {
            try {
                $prod->unique_id = uniqid();
                $response = $prod;
                $status = true;
                $message = trans('default.cart_add_success');
                $cart_prods = Session::get('cart') ?? [];
                array_push($cart_prods, $prod);
                Session::put('cart', $cart_prods);
            } catch (Exception $e) {
                $message = trans('default.cart_add_fail');
            }
        }

        echo(json_encode([
            'success' => $status,
            'message' => $message ?? "",
            'product' => $prod
        ]));
    }

    public function order(\App\Http\Requests\OrderRequest $request) {
        $language = \App\Language::getLocale();
        $cart_products = Session::get('cart');
        $cms = \App\Cms::first()->toArray();
        $answer = explode('_', $request->timestamp);
        $user_answer = intval($answer[1] ?? 0) === intval($request->answer);
        $response = [
            'success' => false,
            'answer' => $user_answer
        ];

        if (!$user_answer) {
            die(json_encode($response));
        }

        $client = [
            'name' => $request->name,
            'phone' => $request->phone,
            'email' => $request->email,
            'address' => $request->address,
            'note' => $request->note,
        ];
        $order = new \App\Order;
        $order->client_data = json_encode($client);
        $order->total_price = 0;
        $order->save();
        $order_id = $order->id;
        $total_price  = 0;

        foreach ($cart_products as $product) {
            $order_product = new \App\OrderProduct;
            $order_product->product_data = json_encode($product);
            $order_product->amount = $product->amount;
            $order_product->total_price = $product->total_price;
            $order_product->order_id = $order_id;
            $order_product->save();
            $total_price += intval($product->total_price)*intval($product->amount);
        }
        $order->total_price = $total_price;
        $order->save();

        Mail::to($cms['order_mail'])
        ->cc($request->email)
        ->send(new MailSender($cart_products, $cms, $client));

        $response['success'] = true;
        Session::put('cart', []);
        
        echo(json_encode($response));

    }

    public function delete($id=null) {
        $cart_prods = Session::get('cart');
        $status = false;

        foreach($cart_prods as $key => $cart_prod){
            if ($cart_prod->unique_id == $id) {
                unset($cart_prods[$key]);
                Session::put('cart', $cart_prods);
                $status = true;
            }
        }

        echo(json_encode([
            'success' => $status,
            'id' => $id,
        ]));
    }


}
