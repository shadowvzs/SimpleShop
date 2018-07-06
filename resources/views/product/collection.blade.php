@extends('layouts.app')
@section('content')

<div class="content col-sm-8 col-md-9 col-lg-10">
	<div class="thumbnail-list pb-4">
		@foreach ($products as $product)
			<div>
				<div class="thumbnail">
					<a href="/prod/{{$product['slug']}}" class="thumbnail-link">
						<div class="image"><img src="{{ asset('img/products/'.$product['main_image']) }}"></div>
						<div class="title">{{$product['name'] ?? 'Untitle'}} </div>
						<div class="price"> {{$product['total_price']}} {{$cms['currency']}}</div>
					</a>
				</div>
			</div>
		@endforeach
	</div>
	<br><br>
</div>
@endsection
