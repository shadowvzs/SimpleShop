@extends('layouts.app')
@section('content')
<div class="content col-sm-8 col-md-9 col-lg-10">
	@if (empty($products))
		<div class="no_product">
			Sorry, but no product 
		</div>
	@else
		<div class="thumbnail-list pb-4 d-flex flex-wrap flex-row">
			@foreach ($products as $product)
					<div class="thumbnail front_thumb">
						<a href="/prod/{{$product['slug']}}" class="thumbnail-link">
							<img src="{{ asset('img/products/'.$product['main_image']) }}" class="image">
							<div class="title">{{$product['name'] ?? 'Untitle'}} </div>
							<div class="price"> {{ round($product['total_price']) }} {{$cms['currency']}}</div>
						</a>
					</div>
			@endforeach
		</div>
	@endif
	<br><br>
</div>
@endsection
