@extends('layouts.app')
@section('content')

<div class='collection-section d-flex mt-4'>

	<div class="category_section">
		<div class="category_box">
			<div class="title text-center" data-toggle="collapse" data-target=".category_list" aria-expanded="false"> {{ __('default.select_category') }} </div>
			<div class="category_list collapse">
				<ul>
					@foreach ($cats as $cat)
						<li>
						@if (empty($cat['Child']))
							<span></span>
							<a href="/collection/{{ $cat['slug'] ?? $cat['id'] }}"> {{ $cat['name'] }} </a>
						@else
							<span data-toggle="collapse" data-target="#cat_item_{{ $cat['id'] }}" aria-expanded="false"></span>
							<a href="/collection/{{ $cat['slug'] ?? $cat['id'] }}"> {{ $cat['name'] }} </a>
							<ul id="cat_item_{{ $cat['id'] }}" class="collapse">
								@foreach ($cat['Child'] as $subcat)
									<li>
										<a href="/collection/{{ $subcat['slug'] ?? $subcat['id'] }}"> {{ $subcat['name'] ?? 'Untitled' }} </a>
									</li>
								@endforeach
							</ul>

						@endif
						</li>
					@endforeach
				</ul>
			</div>
		</div>

		@if (!empty($products))
			<div class="category_box recommanded_box">
				<div class="title text-center"> {{ __('default.recommanded_product') }} </div>
				<div class="category_list">
					@foreach ($random_products as $product)
					<div class="thumbnail">
						<a href="/prod/{{$product['slug'] ?? $product['id']}}" class="d-flex p-3">
							<div class="d-inline-block">
								<img src="{{ asset('img/products/'.$product['main_image']) }}" height="120" class="pr-3">
							</div>
							<div class="d-inline-block rec_texts">
								<div class="rec_title">{{ $product['name'] ?? 'Untitle'}} </div>
								<div class="rec_price"> {{ $product['total_price'] }} {{ $cms['currency'] }}</div>
								<div class="rec_description" title="{{ $product['description'] ?? __('default.no_description') }}"> {{ $product['description'] ?? __('default.no_description') }} </div>
							</div>
						</a>
					</div>
					@endforeach
				</div>
			</div>
		@endif
	</div>

	<div class="separator"></div>
	<div class="product_section">
		<div class="collection_sort_limit">
		<select name="sortby" class="collection_orderby">
			@foreach ($orderby_list as $key => $orderby)
                <option value="{{ $orderby[0] }}" {{ (($pagination['orderby'] ?? "") == $orderby[0] || $key == 0) ? 'selected' : '' }}>{{ __($orderby[1]) }} {{ __($orderby[2]) }}</option>
            @endforeach
		</select>
		<select name="page_limit" class="collection_page_limit">
			@foreach ($page_limits as $limit)
				<option value="{{ $limit }}" {{ ($pagination['page_limit'] ?? "") == $limit ? 'selected' : '' }}>{{ $limit }}</option>
 			@endforeach
		</select>
		</div>
		<br>
		@if (empty($products))
			<div class="no_product p-4 text-center">
				<h2> ... {{ __('default.no_product') }} ... </h2>
			</div>
		@else
			<div class="thumbnail-list d-flex flex-wrap flex-row pb-4">
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
			@if (!empty($pagination['links']))
				<div class="pagination">
					@foreach ($pagination['links'] as $link)
						<a href="/search/{{ $link[1] }}" class="{{$link[3]}} pagination_link" data-field="page_index" data-value="{{$link[2]}}"> {{ $link[0] }} </a>
					@endforeach
				</div>
			@endif
		@endif
	</div>
</div>
@endsection
