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

        <div class="col-sm p-3 map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d5435.928819643834!2d21.929802999629814!3d47.06054848694138!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x474647e056cf23f9%3A0x9a1c1b519cdc1b5b!2sStrada+Dun%C4%83rea+13%2C+Oradea!5e0!3m2!1sro!2sro!4v1524975411442" allowfullscreen="" frameborder="0"></iframe>
        </div>
@endsection
