@extends('layouts.app')

@section('content')
<div class="content col-md-9 col-lg-10">
    {!! $page['content'] !!}
    @if (!empty($products))
        <div class='d-flex flex-row flex-wrap thumbnail-list'>
            @foreach ($products as $product)
                <div class="thumbnail col-12 col-sm-6 col-md-4 col-lg-3">
					<a href="/prod/{{$product['slug'] ?? $product['id']}}" class="d-table">
						<img src="{{ asset('img/products/'.$product['main_image']) }}">
						<div class="caption">
							<div class="d-flex w-100">
								<div class="title">{{ $product['name'] ?? 'Untitle'}} </div>
								<div class="price"> {{ $product['total_price'] }} {{ $cms['currency'] }}</div>
							</div>
							<div class="description" title="{{ $product['description'] ?? __('default.no_description') }}"> {{ $product['description'] ?? __('default.no_description') }} </div>
						</div>
					</a>
				</div>
            @endforeach
        </div>
    @endif
</div>

@endsection
