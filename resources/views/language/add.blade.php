@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Add New Language</div>
                <div class="card-body">
                    <form action='/language/save' method="POST" enctype="multipart/form-data">
                        @method('post')
                        @csrf
                        <input type="text" name="name" placeholder="Language Name" required class="form-control"><br>
                        <input type="text" name="code" placeholder="Language Code (ex. EN)" title="ex: EN, RO, HU" pattern="[a-zA-Z]{2}" required class="form-control"><br>
                        <input type="hidden" name="id" value="0">
                        <input type="file" name="image" accept=".jpg,.png" required><br><br>
                        <input type="checkbox" name="status" checked style="vertical-align: middle;"> Active
                        <input type="submit" class="btn btn-primary float-right" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
