@extends('layouts.admin')
@section('content')

<div class="thumbnail-list mt-4">
	@foreach ($products as $product)
		<div class="thumbnail">
			<a href="/product/edit/{{$product['id']}}" class="d-table">
				<img src="{{ asset('img/products/'.$product['main_image']) }}" height="400">
				<div class="caption">
					<div class="d-flex w-100">
						<div class="title">{{$product['name'] ?? 'Untitle'}} </div>
						<div class="price"> {{$product['total_price']}} {{$cms['currency']}}</div>
					</div>
					<div class="description" title="{{ $product['description'] ?? __('default.no_description') }}"> {{ $product['description'] ?? __('default.no_description') }} </div>
				</div>
				<a href="/product/delete/{{$product['id']}}" class="thumbnail-delete" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-alt" aria-hidden="true"></i></a>
			</a>
		</div>
	@endforeach
</div>
@endsection
