@extends('layouts.app')
@section('content')
<br>
@if (count($errors) > 0)
        <div class="alert alert-danger">
            <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
            </ul>
        </div>
    @endif
<br>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('default.contact_title')}}</div>
                <div class="card-body">
					<form action='/contact/new' method="POST">
						@method('post')
						@csrf
						<input type="text" name="name" placeholder="{{ __('default.contact_name')}}" value="" required class="form-control"><br>
						<input type="text" name="email" placeholder="{{ __('default.contact_email')}}" value="" required class="form-control"><br>
						<input type="text" name="phone" placeholder="{{ __('default.contact_phone')}}" value="" required class="form-control"><br>
						<textarea name="comment" placeholder="{{ __('default.contact_comment')}}" class="form-control mb-4" style="min-height: 200px;"></textarea>
						<input type="submit" class="btn btn-primary float-right" value="{{ __('default.contact_send')}}">
					</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
