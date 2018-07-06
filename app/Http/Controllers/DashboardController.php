<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller {

    public function __construct() {
        parent::__construct();
        $this->middleware('auth');
    }

    public function index() {
        $orders = \App\Order::orderBy('id', 'desc')->paginate(20);
        return view('admin.index', ['orders' => $orders]);
    }

    public function order_view($id) {
        $order = \App\Order::find(intval($id));
        $order['client_data'] = json_decode($order['client_data']);
        $order_products = \App\OrderProduct::where('order_id', intval($id))->get();
        foreach ($order_products as &$product) {
            $product['product_data'] = json_decode($product['product_data']);
        }

        return view('admin.order_view', [
            'order' => $order,
            'order_products' => $order_products
        ]);
    }

    public function order_delete(Request $request) {
        if (!empty($request->orders)) {
            $ids = $request->orders;
            \App\Order::whereIn('id', $ids)->delete();
        }
        return view('admin.index', [
            'orders' => \App\Order::orderBy('id', 'desc')->paginate(20)
        ]);
    }
}
