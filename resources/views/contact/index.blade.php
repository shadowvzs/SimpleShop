@extends('layouts.admin')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card text-center">
							<div class="card-header"> <b>Contacts</b>	</div>
								<div class="card-body p-4" style="position: relative;">
									<div class="right-add-button">
											<a href="/contact/add"><i class="fas fa-plus-square"></i></a>
									</div>
									<table border="0" width="100%" class="contact_table">
                  	@foreach ($contacts as $catName => $conCat)
  										@foreach ($conCat as $contact)
  											<tr>
  												<td width="40">
                            @if ($contact['icon'])
    													<a href="/contact/edit/{{ $contact['id'] }}">
    														  <img src="{{ asset('img/icons/'.$contact['icon']) }}" title="{{ $contact['name'] }}" class="m-1" width="32" height="32">
    													</a>
                            @endif
  												</td>
                          <td class="d-none d-sm-table-cell">
                              <a href="/contact/edit/{{ $contact['id'] }}">
                                  {{ $catName }}
                              </a>
                          </td>
  												<td>
  													{{ $contact['name'] }}
  												</td>
  												<td width="40">
  													{{ $contact['status'] === 1 ? 'On' : 'Off' }}
  												</td>
  												<td width="30">
  													<a href="/contact/delete/{{$contact['id']}}"><i class="fa fa-trash-alt delete-icon"></i></a>
  												</td>
  											</tr>
  										@endforeach
                    @endforeach
									</table>
							</div>
            </div>
        </div>
    </div>
</div>
@endsection
