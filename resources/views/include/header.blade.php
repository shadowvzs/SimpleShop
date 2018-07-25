<?php
	$thisPage = $page ?? ['id' => 0];
?>
<div class="header-line"></div>

<div class="col">
    <div class="logo">
		<a href="/home" title="home">
			<img src="{{ asset('img/cms/'.$cms['logo']) }}" alt="banner">
		</a>
	</div>
</div>

<div class="facebook">
    <div id="fb-root"></div>
    <div class="fb-like"
      data-href="https://moodon.eu"
      data-share="true"
      data-layout="button"
      data-action="like"
      data-show-faces="true">
    </div>
</div>

<div class="burger_frontend d-inline-block d-sm-none">
	<div class="burger-icon" data-toggle="collapse" data-target=".burger_div" aria-expanded="false">
	    <span class="burger-line"></span>
        <span class="burger-line"></span>
        <span class="burger-line"></span>
	</div>
	<div class="burger_div collapse">
		<span id="burger_menu">
			<nav>
				@foreach ($pages as $page)
					@if (isset($page['type']) && $page['type'] != 2 && $page['place'] != 1 && $page['status'] == 1)
						@if (!empty($page['Child']))
							<a href="{{$page['url'] ?? '/'}}" data-toggle="collapse" data-target="#page_b_{{$page['id']}}">{{$page['name'] ?? "unknown"}} <i class="fas fa-caret-down"></i></a>
							<div id="page_b_{{$page['id']}}" class="collapse">
								@foreach ($page['Child'] as $sub_page)
									@if ($sub_page['status'] == 1)
										<a href="{{$sub_page['url'] ?? '/'}}">{{$sub_page['name'] ?? "unknown"}}</a>
									@endif
								@endforeach
							</div>
						@else
							<a href="{{ $page['url'] ?? '/' }}">{{$page['name'] ?? "unknown"}}</a>
						@endif
					@endif
				@endforeach
			</nav>
		</span>
	</div>
</div>

<div class="toolbar">
	<p> {{ __('default.add_to') }} </p>
	<div class="fav_bar">
		<a href="javascript:void(0)" data-toggle="modal" data-target=".favorite-modal" data-amount="0" class="">
			<i class="fas fa-star"></i>
		</a>
	</div>
	<div class="cart_bar">
		<a href="javascript:void(0)" data-toggle="modal" data-target=".cart-modal" data-amount="0" class="">
			<i class="fas fa-shopping-cart"></i>
		</a>
	</div>
</div>

@if (count($available_lang)> 1)
<div class="lang_bar">
	@foreach ($available_lang as $lang)
		@if ($lang['status'] == 1)
			<img src="{{ asset('img/flags/'.$lang['flag']) }}" alt="{{ $lang['name'] }}" data-id="{{ $lang['id'] }}" class="language_choose">
		@endif
	@endforeach
</div>
@endif

<div class="menu d-none d-sm-block">
    <ul>
		@foreach ($pages as $page)
			@if (isset($page['type']) && $page['type'] != 2 && $page['place'] != 1 && $page['status'] == 1)
				@if (!empty($page['Child']))
					<li data-target="page_b_{{$page['id']}}"><a href="{{$page['url'] ?? '/'}}" class="{{ $page['id'] == $thisPage['id'] ? 'selected' : ''}}">{{ $page['name'] ?? "unknown" }} <i class="fas fa-caret-down"></i></a>
						<ul id="page_b_{{$page['id']}}">
							@foreach ($page['Child'] as $sub_page)
								@if ($sub_page['status'] == 1)
									<li><a href="{{ $sub_page['url'] ?? '/'}}">{{$sub_page['name'] ?? "unknown"}}</a></li>
								@endif
							@endforeach
						</ul>
					</li>
				@else
					<li><a href="{{ $page['url'] ?? '/'}}" class="{{ $page['id'] == $thisPage['id'] ? 'selected' : ''}}">{{$page['name'] ?? "unknown"}}</a></li>
				@endif
			@endif
		@endforeach
    </ul>
</div>
