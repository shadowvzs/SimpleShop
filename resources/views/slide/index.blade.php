@extends('layouts.admin')
@section('content')

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
							<div class="card-header"> <b>Slides</b>	</div>
								<div class="card-body p-4" style="position: relative;">
									<div class="right-add-button">
											<a href="/slide/add"><i class="fas fa-plus-square"></i></a>
									</div>
									<table border="0" width="100%">
                      @if (empty($slides))
                          <tr><td> ... empty ... </td></tr>
                      @else
      										@foreach ($slides as $slide)
        											<tr>
                                  <td valign="top">
                                      <h2 style='color:#777;'>{{ $slide['order_id'] }}. </h1>
                                  </td>
          												<td width="40">
          														 <img src="{{ asset('img/slides/'.$slide['image']) }}" class="m-1" height="100">
          												</td>
          												<td valign="middle" width="100" class='text-left'>
                                    <a href="/slide/move/{{ $slide['id'] }}/up">
                                        <i class="fa fa-arrow-circle-up" style="font-size:50px"></i>
                                    </a>
                                    <br>
                                    <a href="/slide/move/{{ $slide['id'] }}/down">
                                        <i class="fa fa-arrow-circle-down" style="font-size:50px" aria-hidden="true"></i>
                                    </a>
                                  </td>
                                  <td valign="top" class='text-center'>
                                       <a href="/slide/delete/{{ $slide['id'] }}" style="color: red;">
                                          <i class="fa fa-trash-alt" style="font-size:24px" aria-hidden="true"></i>
                                      </a>
          												</td>
        											</tr>
      										@endforeach
                      @endif
									</table>
							</div>
            </div>
        </div>
    </div>
</div>
@endsection
