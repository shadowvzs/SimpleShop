@extends('layouts.admin')
@section('content')

<div class="thumbnail-list mt-4">
	@foreach ($products as $product)
		<div>
			<div class="thumbnail">
				<a href="/product/edit/{{$product['id']}}" class="thumbnail-link">
					<div class="image"><img src="{{ asset('img/products/'.$product['main_image']) }}"></div>
					<div class="title">{{$product['name'] ?? 'Untitled'}} </div>
					<div class="price">  {{$product['total_price']}} {{$cms['currency']}}</div>
				</a>
				<a href="/product/delete/{{$product['id']}}" class="thumbnail-delete" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-alt" aria-hidden="true"></i></a>
			</div>
		</div>
	@endforeach
</div>
@endsection
