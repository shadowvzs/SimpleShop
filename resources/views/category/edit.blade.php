@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit {{ $category['name'] }} Category</div>
                <div class="card-body">
									<form action='/category/save' method="POST">
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
												<option value="0"> Main category </option>
												@foreach ($categories as $cat)
                          @if ($category['id'] !== $cat['id'])
													    <option value="{{ $cat['id'] }}" {{ $cat['id'] == $category['parent_id'] ? 'selected' : ''}}> {{$cat['name'] ?? 'Untitled'}}	</option>
                          @endif
												@endforeach
										</select><br>
                    <input type="text" name="name" placeholder="Category" value="{{$category['name']}}" required class="form-control"><br>
                    <textarea name="description" placeholder="Description" class="form-control">{{ $category['description'] }}</textarea><br>
                    <input type="text" name="meta_keyword" placeholder="Meta Keyword" value="{{$category['meta_keyword'] ?? ""}}" class="form-control"><br>
                    <input type="text" name="meta_title" placeholder="Meta Title" value="{{$category['meta_title'] ?? ""}}" class="form-control"><br>
										<textarea name="meta_description" placeholder="Meta Description" class="form-control">{{ $category['meta_description'] ?? "" }}</textarea><br>
                    <br>
                    <input type="hidden" name="id" value="{{ $category['id'] }}">
                    <input type="checkbox" name="status" value="1" {{ $category['status'] === 1 ? 'checked' : ''}} style="vertical-align: middle;"> Active
                    <input type="submit" class="btn btn-primary float-right" value="Save">
									</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
