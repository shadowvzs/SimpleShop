<div class="side-menu">
		<div class="menu">
			@foreach ($pages as $page)
				@if (isset($page['type']) && $page['type'] == 2)
					@if (!empty($page['Child']))
						<a href="{{$page['url'] ?? '/'}}" data-toggle="collapse" data-target="#page_s_{{$page['id']}}">{{$page['name'] ?? "unknown"}}</a>
						<div id="page_s_{{$page['id']}}" class="collapse">
							@foreach ($page['Child'] as $sub_page)
								<a href="{{$sub_page['url'] ?? '/'}}">{{$sub_page['name'] ?? "unknown"}}</a>
								@endforeach
						</div>
					@else
						<a href="{{$page['url'] ?? '/'}}">{{$page['name'] ?? "unknown"}}</a>
					@endif
				@endif
			@endforeach
	</div>
</div>
