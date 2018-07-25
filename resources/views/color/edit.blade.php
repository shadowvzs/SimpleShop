@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit {{ $color['name'] }} Color</div>
                <div class="card-body">
  									<form action='/color/save' method="POST" enctype="multipart/form-data">
    									  @method('post')
    									  @csrf
                        <div class="text-center">
        										@foreach ($languages as $lang)
                                <input type="radio" name="language" id="lang_{{$lang['id']}}" value="{{$lang['id']}}" class="hidden radio-select" {{$language['id'] === $lang['id'] ? 'checked' : ''}}/>
                                <label for="lang_{{$lang['id']}}" title="{{ $lang['name'] ?? ''}}" class="set_lang" data-id={{ $lang['id'] }} data-code={{ $lang['code'] }}>
                                    <img src="{{ asset('img/flags/'.$lang['flag']) }}">
                                </label>
        										@endforeach
                        </div>
    										<input type="text" name="name" placeholder="Color Name" value="{{ $color['name'] }}" required class="form-control">
                        <img src="{{ asset('img/colors/'.$color['image']) }}" title="{{ $color['name'] }}" class="m-3 border border-dark rounded-circle float-right" width="32" height="32">
                        <br><br>
                        <input type="hidden" name="id" value="{{ $color['id'] }}">
    									  <input type="file" name="image" accept=".jpg,.png"><br><br>
                        <input type="checkbox" name="status" value="1" {{ $color['status'] === 1 ? 'checked' : ''}} style="vertical-align: middle;"> Active
                        <input type="submit" class="btn btn-primary float-right" value="Save">
  									</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
