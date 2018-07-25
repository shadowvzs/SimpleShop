@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
                <div class="card-header"> <b>Pages</b>	</div>
                <div class="card-body p-4" style="position: relative;">
                    <div class="right-add-button">
                        <a href="/page/add"><i class="fas fa-plus-square"></i></a>
                    </div>
                    <table border="0" width="100%">
                        @foreach ($frontend_pages as $frontend_page)
                            <tr>
                                <td width="40" class="text-left">
                                    <a href="/page/edit/{{$frontend_page['id']}}">
                                        <span class="badge badge-primary m-1 p-2" title="Edit {{$frontend_page['name'] ?? ''}} page">{{$frontend_page['name'] ?? '??'}}</span>
                                    </a>
                                </td>
                                <td width="20" class="text-right">
                                    {{ $frontend_page['status'] === 1 ? 'On' : 'Off' }}
                                </td>
                                <td width="20">
                                    <a href="/page/delete/{{$frontend_page['id']}}"><i class="fa fa-trash-alt delete-icon"></i></a>
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
