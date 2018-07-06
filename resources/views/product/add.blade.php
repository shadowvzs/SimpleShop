@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Add New Product</div>
                <div class="card-body">
                    <form action='/product/save' method="POST" enctype="multipart/form-data" id='add_product_form'>
                        @method('post')
                        @csrf
                        <div class="text-center">
                            @foreach ($languages as $lang)
                                <input type="radio" name="language" id="lang_{{$lang['id']}}" value="{{$lang['id']}}" class="hidden radio-select" {{$language['id'] === $lang['id'] ? 'checked' : ''}}/>
                                <label for="lang_{{$lang['id']}}" title="{{$lang['name'] ?? ""}}" class="set_lang" data-id={{ $lang['id'] }} data-code={{ $lang['code'] }}>
                                    <img src="{{ asset('img/flags/'.$lang['flag']) }}">
                                </label>
                            @endforeach
                        </div>
                        <input type="text" name="name" placeholder="Product Name" required class="form-control"><br>
                        <textarea name="description" placeholder="Description" class="form-control"></textarea><br>
                        <input type="number" name="price" min="1" placeholder="Price in {{$cms['currency']}}" class="form-control" required style="width: 50%;display: inline-block;">
                        <span class="float-right">
                            <input type="checkbox" name="status" checked style="vertical-align: middle;" value="1"> Active
                        </span><br><br>
                        <select name="category_id" class="form-control">
                            <option value="0"> Select product category </option>
                            @foreach ($categories as $category)
                                <option value="{{ $category['id'] }}"> {{ $category['name'] ?? ''}}	</option>
                            @endforeach
                        </select><br>
                        <div class="card p-3">
                            <div class="d-inline-flex justify-content-center flex-wrap multi-selectable" id="product_color">
                                @foreach ($colors as $color)
                                    <img src="{{ asset('img/colors/'.$color['image']) }}" title="add {{ $color['name'] ?? ''}} color to this product" class="m-1 target rounded-circle" width="32" height="32" data-id="{{$color['id']}}">
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <div class="card p-3">
                            <div class="d-inline-flex justify-content-center flex-wrap multi-selectable" id="product_size">
                                @foreach ($sizes as $size)
                                    <span class="badge badge-primary m-1 p-2 target" title="add {{$size['name'] ?? '??'}} size to this product" data-id="{{$size['id']}}">{{$size['name']}}</span>
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <input type="text" name="meta_title" placeholder="Meta Title" class="form-control"><br>
                        <input type="text" name="meta_keyword" placeholder="Meta Keyword" class="form-control"><br>
                        <textarea name="meta_description" placeholder="Meta Description" class="form-control"></textarea><br>

                        <label for="images" class="selectable p-3 text-center" id="product_images">
                            <span><b>Image for product</b><br>(max. 5mb)</span>
                        </label>
                        <br>
                        <input type="hidden" name="id" value="0">
                        <input type="hidden" name="json" id="json_input">
                        <input type="file" name="images[]" data-type="images" data-target="#product_images" id="images" style="position:absolute;top:-200px;" multiple accept=".jpg,.png">
                        <input type="submit" class="btn btn-primary float-right" value="Save">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
