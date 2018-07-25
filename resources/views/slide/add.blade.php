@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Add New Slide</div>
                <div class="card-body">
                    <form action='/slide/save' method="POST" enctype="multipart/form-data">
                        @method('post')
                        @csrf
                        <input type="hidden" name="id" value="0">
                        <input type="file" name="image[]" accept=".jpg,.png" multiple required><br><br>
                        <input type="submit" class="btn btn-primary float-right" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
