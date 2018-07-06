@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Edit {{$product['name'] ?? 'Untitled'}}</div>
                <div class="card-body">
                    <form action='/product/save' method="POST" enctype="multipart/form-data" id='add_product_form'>
                        @method('post')
                        @csrf
                        <div class="text-center">
                            @foreach ($languages as $lang)
                                <input type="radio" name="language" id="lang_{{$lang['id']}}" value="{{$lang['id']}}" class="hidden radio-select" {{$language['id'] === $lang['id'] ? 'checked' : ''}}/>
                                <label for="lang_{{$lang['id']}}" title="{{$lang['name'] ?? 'unknown'}}" class="set_lang" data-id={{ $lang['id'] }} data-code={{ $lang['code'] }}>
                                    <img src="{{ asset('img/flags/'.$lang['flag']) }}">
                                </label>
                            @endforeach
                        </div>
                        <input type="text" name="name" placeholder="Product Name" value="{{$product['name'] ?? 'Untitled'}}" required class="form-control"><br>
                        <textarea name="description" placeholder="Description" class="form-control">{{$product['description']}}</textarea><br>
                        <input type="number" name="price" min="1" placeholder="Price in {{$cms['currency']}}" value="{{$product['total_price']}}" class="form-control" required style="width: 50%;display: inline-block;">
                        <span class="float-right">
                            <input type="checkbox" name="status" {{$product['status'] === 1 ? 'checked' : ''}} style="vertical-align: middle;"> Active
                        </span>
                        <br><br>
                        <select name="category_id" class="form-control">
                            <option value="0"> Select product category </option>
                            @foreach ($categories as $category)
                                <option value="{{$category['id']}}" {{$product['category_id'] == $category['id'] ? "selected" : ""}}> {{$category['name'] ?? 'Untitled'}}	</option>
                            @endforeach
                        </select><br>
                        <div class="card p-3">
                            <div class="d-inline-flex justify-content-center flex-wrap multi-selectable" id="product_color">
                                @foreach ($colors as $color)
                                    <img src="{{ asset('img/colors/'.$color['image']) }}" title="add {{ $color['name'] ?? '' }} color to this product" class="m-1 target rounded-circle {{in_array($color['id'], $product_color) ? 'active' : ''}}" width="32" height="32" data-id="{{$color['id']}}">
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <div class="card p-3">
                            <div class="d-inline-flex justify-content-center flex-wrap multi-selectable" id="product_size">
                                @foreach ($sizes as $size)
                                    <span class="badge badge-primary m-1 p-2 target {{in_array($size['id'], $product_size) ? 'active' : ''}}" title="add {{$size['name'] ?? '??'}} size to this product" data-id="{{$size['id']}}">{{$size['name']}}</span>
                                @endforeach
                            </div>
                        </div>
                        <br>
                        <input type="text" name="meta_title" placeholder="Meta Title" value="{{$product['meta_title'] ?? ""}}" class="form-control"><br>
                        <input type="text" name="meta_keyword" placeholder="Meta Keyword" value="{{$product['meta_keyword'] ?? ""}}" class="form-control"><br>
                        <textarea name="meta_description" placeholder="Meta Description" class="form-control">{{ $product['meta_description'] ?? "" }}</textarea><br>

                        <div class="old_images selectable p-3 text-center">
                            @foreach ($product_images as $image)
                                <span id="old_image_{{$image['id']}}">
                                    <img src="{{ asset('img/products/'.$image['path']) }}" class="img-thumbnail m-1 target {{ $product['main_image'] === $image['path'] ? 'active' : ''}}" alt="preview" data-id="_{{ $image['id'] }}">
                                    <a data-url="/product/delete_image/{{$image['id']}}" data-target="#old_image_{{$image['id']}}" class="delete"><i class="fa fa-trash-alt" aria-hidden="true"></i></a>
                                </span>
                            @endforeach
                        </div><br>
                        
                        <label for="images" class="selectable p-3 text-center" id="product_images">
                            <span><b>Image for product</b><br>(max. 5mb)</span>
                        </label>
                        <br>
                        <input type="hidden" name="id" value="{{ $product['id'] }}">
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
