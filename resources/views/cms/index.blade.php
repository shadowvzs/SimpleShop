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
                        Logo: <br>
                        <input type="file" name="logo" accept=".jpg,.png"> <br>
                        <br>
                        Cover: <br>
                        <input type="file" name="cover" accept=".jpg,.png"> <br>
                        <br>
                        Decoration: <br>
                        <input type="file" name="decoration" accept=".jpg,.png"></td><br>
                        <br>
                        <center>
                            <table>
                                <tr>
                                    <td class="pr-3">
                                        <input type="checkbox" name="decor_top" value="top" {{ $decor_option->place->top ? 'checked' : ''}} style="vertical-align: middle;"> Top
                                    </td>
                                    <td class="pl-3">
                                        <input type="checkbox" name="decor_right" value="right" {{ $decor_option->place->right ? 'checked' : ''}} style="vertical-align: middle;"> Right
                                    </td>
                                </tr>
                                <tr>
                                    <td class="pr-3">
                                        <input type="checkbox" name="decor_bottom" value="bottom" {{ $decor_option->place->bottom ? 'checked' : ''}} style="vertical-align: middle;"> Bottom
                                    </td>
                                    <td class="pl-3">
                                        <input type="checkbox" name="decor_left" value="left" {{ $decor_option->place->left ? 'checked' : ''}} style="vertical-align: middle;"> Left
                                    </td>
                                </tr>
                            </table>
                        </center>
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
