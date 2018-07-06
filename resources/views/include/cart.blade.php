<div class="col-12 prod_table_div">
    <h2>{{ trans('default.prod_list') }}</h2>
    <table border="0" id="cart_table"> </table>
</div>
<br><hr><br>
<div class="col-12 order_form_div">
    <h2>{{ trans('default.customer_detail') }}</h2>
    <?php
        $a = rand (0 , 10 );
        $b = rand (0 , 10 );
    ?>
    <input type="text" name="name" placeholder="{{ trans('default.form_p_name') }}" required class="form-control"><br>
    <input type="text" name="phone" placeholder="{{ trans('default.form_p_phone') }}" required class="form-control"><br>
    <input type="text" name="email" placeholder="{{ trans('default.form_p_email') }}" required class="form-control"><br>
    <textarea name="address" placeholder="{{ trans('default.form_p_address') }}" class="form-control"></textarea><br>
    <textarea name="note" placeholder="{{ trans('default.order_comment') }}" class="form-control"></textarea><br>
    <div class="order_question_div">{{ trans('default.order_question') }}: {{ $a }} + {{ $b }} = ?</div>
    <input type="text" name="code" placeholder="{{ trans('default.order_q_placeholder') }}" required class="form-control"><br>
    <input type="hidden" name="timestamp" value="{{ time().'_'.($a+$b) }}"><br>
    <p class="order_note">{{ trans('default.order_note') }}</p>
    <button class="btn btn-primary float-right order_button" disabled>{{ trans('default.buy') }}</button>
</div>
<button type="button" style="opacity: 0;" data-dismiss="modal" id="cart-close"> x </button>
<script>
var cart = {
    init: function() {
        cart.icon = document.querySelector('.cart_bar a');
        cart.table = document.getElementById('cart_table');
        cart.items = [];
        cart.orderButton = $('.order_form_div .order_button');
        cart.table.innerHTML = '';
        $.ajax({
            method: "GET",
            url: "/cart",
            dataType: "json",
            async: true
        })
        .done(function( response ) {
            if (response.success && response.items) {
                var c = response.items.length, keys;
                //cart.items = response.items;
                keys = Object.keys(response.items);
                if ( keys.length ) {
                    keys.forEach(function(i){
                        cart.add(response.items[i], true);
                    });
                    cart.icon.classList.add("mini_badge");
                    cart.icon.dataset.amount = Object.keys(cart.items).length;
                } else {
                    cart.table.innerHTML = '<tr><td class="cart_empty text-center">{{ trans("default.cart_empty") }}</td></tr>';
                }
                cart.items = response.items;
            }
        });
    },
    add: function(prod, init=false) {
        var hash = JSON.stringify(prod);

        if (cart.hash === hash && !init) {
            return $.notify("{{ trans('default.ongoing_request') }}", "error");
        }

        cart.hash = hash;

        if (init) {
            cart.pushItem(prod);
            return;
        }

        $.ajax({
            type: "POST",
            url: "/cart/add",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: { prod: JSON.stringify(prod) },
            dataType: "json",
            async: true
        })
        .done(function( response ) {
            if (response.message) {
                $.notify(response.message, response.success ? "info" : "error");
            }
            cart.hash = null;
            if (response.success && response.product) {
                cart.pushItem(response.product);
                if (!cart.icon.classList.contains('thatClass')) {
                    cart.icon.classList.add("mini_badge");
                }
            }
            cart.icon.dataset.amount = Object.keys(cart.items).length;

        }).fail(function(){
            cart.hash = null;
        });
    },
    pushItem: function(prod) {
        var row;
        var td = [];
        var subTr = [];
        var keys = Object.keys(cart.items);
        if (!keys.length) {
            cart.table.innerHTML = '';
        }
        keys++;
        cart.items[keys] = prod;
        row = cart.table.insertRow(-1);
        row.id = "cart_row_"+prod.unique_id;
        subTr[0] = '<tr class="cart_table_title"><td colspan="2">'+prod.name+'</td></tr>';
        subTr[1] = '<tr class="cart_table_amount"><td>{{ trans("default.amount") }}:&nbsp;&nbsp;&nbsp;&nbsp;</td><td id="cart_prod_name_'+prod.id+'" class="text-center">'+(prod.amount || '0')+'</td></tr>';
        subTr[2] = '<tr class="cart_table_color"><td>{{ trans("default.prod_color") }}:&nbsp;&nbsp;&nbsp;&nbsp;</td><td class="text-center"> <img src="/img/colors/'+prod.color.image+'" class="cart_color"></td></tr>';
        subTr[3] = '<tr class="cart_table_size"><td>{{ trans("default.prod_size") }}:&nbsp;&nbsp;&nbsp;&nbsp;</td><td class="text-center">'+prod.size.name+'</td></tr>';
        td[0] = '<td class="cart_image"><a href="/prod/'+prod.slug+'" class="cart_preview"><img src="/img/products/'+prod.main_image+'"></a></td>';
        td[1] = '<td class="cart_details"><table class="cart_details_table">'+subTr.join('')+'</table></td>';
        td[2] = '<td><a href="javascript:void(0)" class="delete-link" data-id="'+prod.unique_id+'" onclick="cart.remove(this)" class="d-block">&times;</a></td>';
        row.innerHTML = td.join('');
        if (cart.orderButton.prop('disabled')) {
            cart.orderButton.prop('disabled', false);
            cart.icon.classList.add("mini_badge");
        }

    },
    remove: function(elem) {
        var id = $(elem).data('id');
        var data = favorites.data;
        $.ajax({
            method: "GET",
            url: "/cart/delete/"+id,
            dataType: "json",
            async: true
        })
        .done(function( response ) {
            if (!response.success) {
                return $.notify( "{{ trans('default.cart_remove_error') }}", 'error');
            }
            if (response.success && response.id) {
                var id = response.id;

                Object.keys(cart.items).forEach(function(k){
                    if (cart.items[k].unique_id == id) {
                        delete cart.items[k];
                    }
                });

                cart.icon.dataset.amount = Object.keys(cart.items).length;

                if (!Object.keys(cart.items).length) {
                    if (!cart.orderButton.prop('disabled')) {
                        cart.orderButton.prop('disabled', true);
                    }
                    cart.icon.classList.remove("mini_badge");
                    cart.table.innerHTML = '<tr><td class="cart_empty text-center">{{ trans("default.cart_empty") }}</td></tr>';
                }

                $("#cart_row_"+id).remove();
            }
            $.notify( "{{ trans('default.cart_remove_ok') }}", 'info');
        });
    },
    order: function() {
        $.ajax({
            type: "POST",
            url: "/cart/order",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
                answer: $('input[name=code]').val(),
                name: $('input[name=name]').val(),
                phone: $('input[name=phone]').val(),
                email: $('input[name=email]').val(),
                address: $('textarea[name=address]').val(),
                timestamp: $('input[name=timestamp]').val(),
                note: $('textarea[name=note]').val(),
            },
            dataType: "json",
            async: true,
            error:function( response ){
                if (response && response.responseText) {
                    var resp = JSON.parse(response.responseText);
                    if (resp.errors) {
                        var errorResponse = resp.errors;
                        var errorMsg = "";
                        var keys = Object.keys(errorResponse);
                        keys.forEach(function(e) {
                            errorMsg += e[0].toUpperCase() + e.slice(1)+": "+errorResponse[e].join('\n')+"\n";
                        });
                        $.notify( errorMsg, 'error');
                        return;
                    }
                }
            },
            success: function( response ) {
                if (!response.success) {
                    $.notify( "{{ trans('default.wrong_answer') }}", 'error');
                    return;
                }
                $.notify( "{{ trans('default.order_sent') }}", 'success');
                cart.items = {};
                cart.table.innerHTML = '<tr><td class="cart_empty text-center">{{ trans("default.cart_empty") }}</td></tr>';
                cart.orderButton.prop('disabled', false);
                cart.icon.dataset.amount = 0;
                cart.icon.classList.remove("mini_badge");
                $('#cart-close').trigger( "click" );
            },
        });
    }
}

$( document ).ready(function() {
    cart.init();
    var sel = $('#add_cart_btn');
    $('.order_button').click(function(){
        cart.order();
    });
    if (sel.length) {
        sel.click( function() {
            var prod = JSON.parse($('#prod_data').val());
            var color = $('input[name=color]:checked').val();
            var size = $('input[name=size]:checked').val();
            if (!color || !size) {
                var msg;
                if (!size && !color) {
                    msg = "{{ trans('default.prod_scs') }}!";
                } else if (!size) {
                    msg = "{{ trans('default.prod_size') }}";
                } else {
                    msg = "{{ trans('default.prod_color') }}";
                }
                $.notify( msg, 'error');
                return;
            }
            prod['color'] = (prod['colors'].filter(c => c.id == color))[0];
            prod['size'] = (prod['sizes'].filter(s => s.id == size))[0];
            prod['amount'] = $('#prod_amount').val() || 0;
            delete prod['colors'];
            delete prod['sizes'];
            delete prod['category'];
            delete prod['images'];
            prod['unique_id'] = Date.now()+'_'+ (~~(Math.random()*1000000));
            cart.add(prod);
        });
    }
});
</script>
