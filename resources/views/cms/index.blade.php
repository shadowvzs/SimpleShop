@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header"> Settings </div>
                <div class="card-body">
                    <form action='/setting/save' method="POST" enctype="multipart/form-data">
                        @method('post')
                        @csrf
                        <input type="text" name="name" placeholder="Site name" value="{{ $cms['name'] }}" required class="form-control"><br>
                        <input type="text" name="map" placeholder="Google map url" value="{{ $cms['map'] }}" required class="form-control"><br>
                        <input type="text" name="order_mail" placeholder="Order email address" value="{{$cms['order_mail']}}" class="form-control"><br>
                        <input type="text" name="currency" placeholder="Currency" value="{{ $cms['currency'] }}" required class="form-control"><br>
                        <textarea name="footer_text" placeholder="Footer text" class="form-control">{{ $ms['footer_text'] ?? "" }}</textarea><br>
                        Logo: <br>
                        <input type="file" name="logo" accept=".jpg,.png"> <br>
                        <br>
                        <br><br>
                        <input type="submit" class="btn btn-primary float-right" value="Save">
                    </form>
                    <br>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
