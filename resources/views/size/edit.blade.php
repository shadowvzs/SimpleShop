@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit {{ $size['name'] }} Size</div>
                <div class="card-body">
									<form action='/size/save' method="POST">
									  @method('post')
									  @csrf
										<input type="text" name="name" placeholder="Size" value="{{$size['name']}}" required class="form-control">
                    <br><br>
                    <input type="hidden" name="id" value="{{ $size['id'] }}">
                    <input type="checkbox" name="status" value="1" {{ $size['status'] === 1 ? 'checked' : ''}} style="vertical-align: middle;"> Active
                    <input type="submit" class="btn btn-primary float-right" value="Save">
									</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
