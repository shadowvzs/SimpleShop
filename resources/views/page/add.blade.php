@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Add New Page</div>
                <div class="card-body">
					<form action='/page/save' method="POST">
					@method('post')
					@csrf
                    <div class="text-center">
  						@foreach ($languages as $lang)
							<input type="radio" name="language" id="lang_{{$lang['id']}}" value="{{$lang['id']}}" class="hidden radio-select" {{$language['id'] === $lang['id'] ? 'checked' : ''}}/>
							<label for="lang_{{$lang['id']}}" title="{{$lang['name']}}" class="set_lang" data-id={{ $lang['id'] }} data-code={{ $lang['code'] }}>
							  <img src="{{ asset('img/flags/'.$lang['flag']) }}">
							</label>
  						@endforeach
                    </div>
                    <select name="parent_id" class="form-control">
						<option value="0"> No Parent </option>
						@foreach ($frontend_pages as $frontend_page)
							<option value="{{ $frontend_page['id'] }}"> {{$frontend_page['name'] ?? ""}}	</option>
						@endforeach
					</select><br>
                    <select name="place" class="form-control">
						<option value="0"> {{ __('default.top') }} </option>
						<option value="1"> {{ __('default.bottom') }}	</option>
					</select><br>
                    <div class="text-center">
						<select name="type" class="form-control" id="page_type">
							@foreach (['Normal', 'Product Category'] as $id => $type)
							  <option value="{{ $id }}">{{ $type }}</option>
							@endforeach
						</select>
                    </div><br>
                    <select name="category" class="form-control mb-4">
                        <option value="0" data-slug=""> All Product	</option>
						@foreach ($categories as $cat)
							<option value="{{$cat['id']}}" data-slug="{{ $cat['slug'] }}"> {{$cat['name'] ?? "Untitled"}}	</option>
						@endforeach
					</select>
                    <input type="text" name="name" placeholder="Page Name" value="" required class="form-control"><br>
                    <input type="text" name="url" placeholder="Page URL" value="" required class="form-control"><br>
                    <span id='url_hint'><b>Example URL: </b>/example <br></span><br>
                    <textarea name="content" placeholder="Content" class="form-control mb-4"></textarea>
                    <input type="text" name="meta_title" placeholder="Meta Title" class="form-control"><br>
                    <input type="text" name="meta_keyword" placeholder="Meta Keywords" class="form-control"><br>
                    <textarea name="meta_description" placeholder="Meta Description" class="form-control"></textarea><br>
                    <input type="hidden" name="id" value="0">
                    <input type="checkbox" name="status" checked style="vertical-align: middle;"> Active
                    <input type="submit" class="btn btn-primary float-right" value="Save">
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
