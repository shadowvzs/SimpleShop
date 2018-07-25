@extends('layouts.admin')
@section('content')

<?php
    $client = $order['client_data'];
    $total_price = 0;
?>

<div class="card mx-auto" style="max-width: 500px;">
    <div class="card-header">
        <h3>Orders #{{$order['id']}}</h3>
    </div>
    <div class="card-body">
        <table class="table order_table text-center mx" width="100%">
            @foreach($order_products as $product)
                <?php
                    $product = $product['product_data'];
                ?>
                <tr>
                    <td>
                        <a href="/prod/{{ $product-> slug }}">
                            <img src="{{ asset('img/products/'.$product->main_image) }}" height="100" style="vertical-align: top;">
                        </a>
                    </td>
                    <td>
                        <img src="{{ asset('img/colors/'.$product->color->image) }}" width="100" height="100" style="border-radius: 50%;">
                    </td>
                </tr>
                <tr>
                    <td colspan="2"> {{ $product->name }} - {{ $product->amount }} {{ trans('default.qty')}} - {{ $product->color->name}} </td>
                </tr>
                <tr>
                    <td colspan="2"> {{ trans('default.size') }}: {{ $product->size->name }} </td>
                </tr>
                <tr>
                    <td colspan="2"> <b> {{ trans('default.prod_price') }}: {{ $product->total_price }} {{ $cms['currency']}} </b> </td>
                </tr>
                <tr><td colspan="2"> <br> </td></tr>
            @endforeach
            <tr><td colspan="2"><br></td></tr>
            <tr><td> </td><td><h3> {{ trans('default.prod_total_cost') }}: {{ $order->total_price }} {{ $cms['currency']}}</h3></td></tr>
        </table>

        <table style="min-width: 300px;" width="100%" >
            <tr>
                <td> {{ trans('default.client_name') }}: </td> <td> {{ $client->name }} </td>
            </tr>
            <tr>
                <td> {{ trans('default.client_phone') }}: </td> <td> {{ $client->phone }} </td>
            </tr>
            <tr>
                <td> {{ trans('default.client_email') }}: </td> <td> {{ $client->email }} </td>
            </tr>
            <tr>
                <td> {{ trans('default.client_address') }}: </td> <td> {{ $client->address }} </td>
            </tr>
            <tr>
                <td> {{ trans('default.client_note') }}: </td> <td> {{ $client->note }} </td>
            </tr>
        </table>
    </div>
</div>
@endsection
