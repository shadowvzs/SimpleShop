@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
							<div class="card-header"> <b>Languages</b>	</div>
								<div class="card-body p-4" style="position: relative;">
									<div class="right-add-button">
											<a href="/language/add"><i class="fas fa-plus-square"></i></a>
									</div>
									<table border="0" width="100%">
										@foreach ($languages as $lang)
											<tr>
												<td width="40">
													<a href="/language/edit/{{$lang['id']}}">
														<img src="{{ asset('img/flags/'.$lang['flag']) }}" title="{{ $lang['name'] }}" class="m-1" width="32" height="32">
													</a>
												</td>
												<td>
													{{ $lang['name'] }}
												</td>
												<td width="40">
													{{ $lang['status'] === 1 ? 'On' : 'Off' }}
												</td>
												<td width="30">
													<a href="/language/delete/{{$lang['id']}}"><i class="fa fa-trash-alt delete-icon"></i></a>
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
