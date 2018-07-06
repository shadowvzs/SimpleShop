@extends('layouts.app')
@section('content')

<div class="row product-view">
	<div class='col-12 col-sm-5 mt-4'>
		<div class='bigImage col-12'>
			<img src="{{ asset('img/products/'.$prod['main_image']) }}" id="zoom_01" data-zoom-image="{{ asset('img/products/'.$prod['main_image']) }}">
		</div>

		<div class='mini_image_box'>
			<div class="container d-flex flex-row">
				@foreach ($prod['images'] as $image)
					<img src="{{ asset('img/products/'.$image['path']) }}" class="mini_image" data-url="{{ asset('img/products/'.$image['path']) }}">
				@endforeach
			</div>
		</div>
	</div>

	<div class='pull-right col-12 col-sm-7 mt-4'>
		<div class='m-4'>
			<h1 class="prod_title">{{$prod['name'] ?? ""}}</h1>
			<div class="prod_code">{{ Lang::get('default.prod_code') }}: {{ str_pad($prod['id'], 4, "0", STR_PAD_LEFT) }}</div>
			<div class="prod_price">{{ Lang::get('default.prod_price') }}: {{ $prod['total_price'] }} {{$cms['currency']}}</div>
			<div class="prod_description">
				<h2>{{ Lang::get('default.prod_description') }}</h2>
				<p> {!! $prod['description'] ?? "" !!} </p>
			</div>
			<div class="prod_color">
				<p>{{ Lang::get('default.prod_color') }}</p>
				<div class="d-inline-flex justify-content-center flex-wrap color_box">
					@foreach ($prod['colors'] as $i => $color)
						<input type="radio" name="color" id="color_{{ $color['id'] }}" value="{{ $color['id'] }}" class="hidden radio-select"/>
						<label for="color_{{ $color['id'] }}" title="{{ $color['name'] ?? "untitled"}}">
							<img src="{{ asset('img/colors/'.$color['image']) }}" title="{{ Lang::get('default.select_color') }}: {{$color['name']}}" class="m-1 rounded-circle" width="32" height="32" data-id="{{$color['id']}}">
						</label>
					@endforeach
				</div>
			</div>
			<div class="prod_size">
				<p>{{ Lang::get('default.prod_size') }}</p>
				<div class="d-inline-flex justify-content-center flex-wrap selectable">
					@foreach ($prod['sizes'] as $i => $size)
						<input type="radio" name="size" id="size_{{ $size['id'] }}" value="{{ $size['id'] }}" class="hidden radio-select"/>
						<label for="size_{{ $size['id'] }}" title="{{ $size['name'] }}">
							<span class="badge badge-primary m-1 p-2" title="add {{ Lang::get('default.select_size') }}: {{$size['name']}}" data-id="{{$size['id']}}">{{$size['name']}}</span>
						</label>
					@endforeach
					<label data-attr-link="true">
						<span class="badge badge-primary m-1 p-2" data-toggle="modal" data-target="#myModal"> {{ Lang::get('default.size_chart') }} </span>
					</label>
				</div>
			</div>
			<div class="prod_amount">
				<p>{{ Lang::get('default.amount') }}</p>
				<div class="d-inline-flex justify-content-center flex-wrap selectable" id="product_color">
					<button class="prod_amount_change">-</button>
					<input type="text" name="size" id="prod_amount" value="1" class=""/>
					<button class="prod_amount_change">+</button>
				</div>
			</div>
			<br>
			<input type="hidden" id="prod_id" value="{{ $prod['id'] }}">
			<input type="hidden" id="prod_data" value="{{ json_encode($prod) }}">
			<div class="prod_order">
				<button type="button" class="btn btn-success m-1" id="add_cart_btn" disabled title="{{ trans('default.prod_scs') }}"> {{ Lang::get('default.add_to_cart') }} </button>
				<button type="button" class="btn btn-info m-1" id="add_favorite_btn"> {{ Lang::get('default.add_to_favorite') }} </button>
			</div>
		</div>
	</div>
</div>

@include('include.sizechart')

<br><br>

<script>
$( document ).ready(function() {
	//localStorage.removeItem('favorites');
	var bigImage = '#zoom_01';
	var zoomConfig = {
		zoomType: "inner",
		cursor: "crosshair",
		zoomWindowFadeIn: 500,
		zoomWindowFadeOut: 750
	};
	var input_id = $('#prod_id');

	if ($( document ).width() > 600) {
		elevateZoomInit();
	}

	$('.mini_image').click(function(){
		var url = $(this).data('url');
		var spt = $(document).scrollTop();
		$('.zoomContainer').remove();
		$(document).scrollTop()
		$(bigImage).prop('src', url);
		$(document).scrollTop(spt);
		$(bigImage).data('zoom-image', url);
		elevateZoomInit();
	});

	function elevateZoomInit(){
		var $j = jQuery.noConflict();					//	var $j = $.noConflict();
		$('#zoom_01').elevateZoom(zoomConfig);
	}

	$('.prod_amount .prod_amount_change').click(function() {
		var dir = $(this).text();
		var inp = $('#prod_amount');
		var amount = inp.val();
		if ((amount < 100) && (dir == "+")) {
			amount++;
		} else if ((amount > 1) && (dir == "-")) {
			amount--;
		}
		inp.val(amount);
	});

	$('input[type=radio]').change(function (){
		var color = $('input[name=color]:checked').val();
		var size = $('input[name=size]:checked').val();
		var status = color && size;
		if (!status) {
			var button = $('#add_cart_btn');
			if (!size) {
				msg = "{{ trans('default.prod_size') }}";
			} else {
				msg = "{{ trans('default.prod_color') }}";
			}
			button.prop('title', msg);
		}
		$('#add_cart_btn').prop('disabled', !status);
	});
});

</script>

@endsection
