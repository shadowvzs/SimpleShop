@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
							<div class="card-header"> <b>Sizes</b>	</div>
								<div class="card-body p-4" style="position: relative;">
									<div class="right-add-button">
											<a href="/size/add"><i class="fas fa-plus-square"></i></a>
									</div>
									<table border="0" width="100%">
										@foreach ($sizes as $size)
											<tr>
												<td width="40" class="text-left">
													<a href="/size/edit/{{$size['id']}}">
														<span class="badge badge-primary m-1 p-2" title="Edit {{$size['name']}} size">{{$size['name']}}</span>
													</a>
												</td>
												<td width="20" class="text-right">
													{{ $size['status'] === 1 ? 'On' : 'Off' }}
												</td>
												<td width="20">
													<a href="/size/delete/{{$size['id']}}"><i class="fa fa-trash-alt delete-icon"></i></a>
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
