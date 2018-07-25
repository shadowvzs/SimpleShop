@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Add New Size</div>
                <div class="card-body">
									<form action='/size/save' method="POST">
									  @method('post')
									  @csrf
										<input type="text" name="name" placeholder="Size" required class="form-control"><br>
	                  <input type="hidden" name="id" value="0">
                    <input type="checkbox" name="status" checked style="vertical-align: middle;"> Active
                    <input type="submit" class="btn btn-primary float-right" value="Save">
									</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
