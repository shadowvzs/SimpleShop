@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header"> <b>Categories</b>	</div>
                <div class="card-body p-4" style="position: relative;">
                    <div class="right-add-button">
                        <a href="/category/add"><i class="fas fa-plus-square"></i></a>
                    </div>
                    <table border="0" width="100%">
                        @foreach ($categories as $category)
                            <tr>
                                <td width="40" class="text-left">
                                    <a href="/category/edit/{{$category['id']}}">
                                        <span class="badge badge-primary m-1 p-2" title="Edit {{$category['name'] ?? 'Untitled'}} category">{{$category['name'] ?? 'Untitled'}}</span>
                                    </a>
                                </td>
                                <td width="20" class="text-right">
                                    {{ $category['status'] === 1 ? 'On' : 'Off' }}
                                </td>
                                <td width="20">
                                    <a href="/category/delete/{{$category['id']}}"><i class="fa fa-trash-alt delete-icon"></i></a>
                                </td>
                            </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
