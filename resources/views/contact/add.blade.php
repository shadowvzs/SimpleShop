@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Add New Contact</div>
                <div class="card-body">
                    <form action='/contact/save' method="POST" enctype="multipart/form-data">
                        @method('post')
                        @csrf
                        <div class="text-center">
                            @foreach ($languages as $lang)
                                <input type="radio" name="language" id="lang_{{$lang['id']}}" value="{{$lang['id']}}" class="hidden radio-select" {{$language['id'] === $lang['id'] ? 'checked' : ''}}/>
                                <label for="lang_{{$lang['id']}}" title="{{$lang['name'] ?? ''}}"  class="set_lang" data-id={{ $lang['id'] }} data-code={{ $lang['code'] }}>
                                    <img src="{{ asset('img/flags/'.$lang['flag']) }}">
                                </label>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <select name="type" class="form-control">
                                @foreach (['Normal', 'Social'] as $id => $type)
                                    <option value="{{ $id }}">{{ $type }}</option>
                                @endforeach
                            </select>
                        </div><br>
                        <input type="text" name="name" placeholder="Contact Name" required class="form-control"><br>
                        <input type="text" name="value" placeholder="Contact URL" required class="form-control"><br>
                        <input type="hidden" name="id" value="0">
                        <input type="file" name="image" accept=".jpg,.png"><br><br>
                        <input type="checkbox" name="status" checked style="vertical-align: middle;"> Active
                        <input type="submit" class="btn btn-primary float-right" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
