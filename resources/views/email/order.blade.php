<table style="width: 100%;max-width: 500px;">
    <?php $total_price = 0; ?>
    @foreach($products as $product)
        <?php
            $prod_price = intval($product->amount)*($product->total_price);
            $total_price += $prod_price;
        ?>
        <tr>
            <td>
                <img src="{{ asset('img/products/'.$product->main_image) }}" height="100" style="vertical-align: top;">
            </td>
            <td>
                <img src="{{ asset('img/colors/'.$product->color->image) }}" width="100" height="100" style="border-radius: 50%;">
            </td>
        </tr>
        <tr>
            <td colspan="2"> {{ $product->name }} - {{ $product->amount }} {{ trans('default.qty')}} - {{ $product->color->name}} </td>
        </tr>
        <tr>
            <td colspan="2"> {{ trans('default.prod_size') }}: {{ $product->size->name }} </td>
        </tr>
        <tr>
            <td colspan="2"> <b> {{ trans('default.prod_price') }}: {{ $prod_price }} {{ $cms['currency']}} </b> </td>
        </tr>
        <tr><td colspan="2"> <br> </td></tr>
    @endforeach
    <tr><td colspan="2"><br></td></tr>
    <tr><td> </td><td><h3> {{ trans('default.prod_total_cost') }}: {{ $total_price }} {{ $cms['currency']}}</h3></td></tr>
</table>

<table style="min-width: 300px;">
    <tr>
        <td> {{ trans('default.client_name') }}: </td> <td> {{ $client['name'] }} </td>
    </tr>
    <tr>
        <td> {{ trans('default.client_phone') }}: </td> <td> {{ $client['phone'] }} </td>
    </tr>
    <tr>
        <td> {{ trans('default.client_email') }}: </td> <td> {{ $client['email'] }} </td>
    </tr>
    <tr>
        <td> {{ trans('default.client_address') }}: </td> <td> {{ $client['address'] }} </td>
    </tr>
    <tr>
        <td> {{ trans('default.client_note') }}: </td> <td> {{ $client['note'] }} </td>
    </tr>
</table>
