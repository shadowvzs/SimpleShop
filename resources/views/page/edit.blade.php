@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit {{ $page['name'] ?? "Untitled" }} Page</div>
                <div class="card-body">
					<form action='/page/save' method="POST">
						@method('post')
						@csrf
						<div class="text-center">
											@foreach ($languages as $lang)
							<input type="radio" name="language" id="lang_{{ $lang['id'] }}" value="{{ $lang['id'] }}" class="hidden radio-select" {{$language['id'] === $lang['id'] ? 'checked' : ''}}/>
							<label for="lang_{{ $lang['id'] }}" title="{{ $lang['name'] ?? "Untitled" }}" class="set_lang" data-id={{ $lang['id'] }} data-code={{ $lang['code'] }}>
							  <img src="{{ asset('img/flags/'.$lang['flag']) }}">
							</label>
											@endforeach
						</div>
						<select name="parent_id" class="form-control">
							<option value="0"> No Parent </option>
							@foreach ($frontend_pages as $frontend_page)
								@if ($page['id'] !== $frontend_page['id'])
									<option value="{{ $frontend_page['id'] }}" {{ $frontend_page['id'] == $page['parent_id'] ? 'selected' : ''}}> {{$frontend_page['name'] ?? ""}}	</option>
								@endif
							@endforeach
						</select><br>
						<select name="place" class="form-control">
							<option value="0" {{$page['place'] != 1 ? 'selected' : ''}}> {{ __('default.top') }} </option>
							<option value="1" {{$page['place'] == 1 ? 'selected' : ''}}> {{ __('default.bottom') }}	</option>
						</select><br>
						<div class="text-center">
						  <select name="type" id="page_type" class="form-control">
							@foreach (['Normal', 'Product Category'] as $id => $type)
							  <option value="{{ $id }}" {{ $page['type'] === $id ? 'selected' : ''}}>{{ $type }}</option>
							@endforeach
						  </select>
						</div><br>
						<select name="category" class="form-control mb-4">
							<option value="0" data-slug=""> All Product	</option>
							@foreach ($categories as $cat)
								 <option value="{{ $cat['id'] }}" {{ $page['category_id'] == $cat['id'] ? 'selected' : ''}} data-slug="{{ $cat['slug'] }}"> {{$cat['name'] ?? "Untitled"}}	</option>
							@endforeach
						</select>
						<input type="text" name="name" placeholder="Page name" value="{{ $page['name'] ?? 'Untitled' }}" required class="form-control"><br>
						<input type="text" name="url" placeholder="Page URL" value="{{ $page['url'] ?? ''}}" required class="form-control"><br>
						<span id='url_hint'><b>Example URL: </b>/example <br></span><br>
						<textarea name="content" placeholder="Content" class="form-control mb-4">{{ $page['content'] ?? "" }}</textarea>
						<input type="text" name="meta_keyword" placeholder="Meta Keyword" value="{{$page['meta_keyword'] ?? ""}}" class="form-control"><br>
						<input type="text" name="meta_title" placeholder="Meta Title" value="{{$page['meta_title'] ?? ""}}" class="form-control"><br>
											<textarea name="meta_description" placeholder="Meta Description" class="form-control">{{ $page['meta_description'] ?? ""}}</textarea><br>
						<br>
						<input type="hidden" name="id" value="{{ $page['id'] }}">
						<input type="checkbox" name="status" value="1" {{ $page['status'] === 1 ? 'checked' : ''}} style="vertical-align: middle;"> Active
						<input type="submit" class="btn btn-primary float-right" value="Save">
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
