@extends('layouts.admin')
@section('content')
<div class="thumbnail-list mt-4">
	@foreach ($products as $product)
			<div class="thumbnail col-12 col-sm-6 col-md-4 col-lg-3">
				<a href="/product/edit/{{$product['id']}}" class="thumbnail-link">
					<img src="{{ asset('img/products/'.$product['main_image']) }}" class="image">
					<div class="title">{{$product['name'] ?? 'Untitled'}} </div>
					<div class="price">  {{$product['total_price']}} {{$cms['currency']}}</div>
				</a>
				<a href="/product/delete/{{$product['id']}}" class="thumbnail-delete" onclick="return confirm('Are you sure?')"><i class="fa fa-trash-alt" aria-hidden="true"></i></a>
			</div>
	@endforeach
</div>
@endsection