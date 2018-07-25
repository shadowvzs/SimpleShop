@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit {{ $lang['name'] }} Language</div>
                <div class="card-body">
                    <form action='/language/save' method="POST" enctype="multipart/form-data">
                        @method('post')
                        @csrf
                        <input type="text" name="name" placeholder="Language Name" value="{{ $lang['name'] }}" required class="form-control"><br>
                        <input type="text" name="code" placeholder="Language Code (ex. EN)" value="{{ $lang['code'] }}" pattern="[a-zA-Z]{2}" title="ex: EN, RO, HU" required class="form-control">
                        <img src="{{ asset('img/flags/'.$lang['flag']) }}" title="{{ $lang['name'] }}" class="m-3 float-right" width="32" height="32">
                        <br><br>
                        <input type="hidden" name="id" value="{{ $lang['id'] }}">
                        <input type="file" name="image" accept=".jpg,.png"><br><br>
                        <input type="checkbox" name="status" value="1" {{ $lang['status'] === 1 ? 'checked' : ''}} style="vertical-align: middle;"> Active
                        <input type="submit" class="btn btn-primary float-right" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
