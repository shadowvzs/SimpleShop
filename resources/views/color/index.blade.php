@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
							<div class="card-header"> <b>Colors</b>	</div>
								<div class="card-body p-4" style="position: relative;">
									<div class="right-add-button">
											<a href="/color/add"><i class="fas fa-plus-square"></i></a>
									</div>
									<table border="0" width="100%">
										@foreach ($colors as $color)
											<tr>
												<td width="40">
													<a href="/color/edit/{{$color['id']}}">
														<img src="{{ asset('img/colors/'.$color['image']) }}" title="{{ $color['name'] }}" class="m-1 border border-dark rounded-circle" width="32" height="32">
													</a>
												</td>
												<td>
													{{ $color['name'] }}
												</td>
												<td width="40">
													{{ $color['status'] === 1 ? 'On' : 'Off' }}
												</td>
												<td width="30">
													<a href="/color/delete/{{$color['id']}}"><i class="fa fa-trash-alt delete-icon"></i></a>
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
