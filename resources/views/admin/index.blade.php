@extends('layouts.admin')
@section('content')

<div class="card mx-auto" style="max-width: 500px;">
	<div class="card-body">
		<form action='/order/delete' method="POST">
			@method('post')
			@csrf
			<table class="table order_table text-center" width="100%">
				<thead class="thead-light">
					<th>Id</th>
					<th>Price</th>
					<th>Date</th>
					<th><input type="checkbox" name="select_all"></th>
				</thead>
				@if ($orders->count() > 0)
					@foreach ($orders as $order)
						<tr>
							<td class="order"><a href="/dashboard/view/{{$order['id']}}">#{{ $order['id'] }}</a></td>
							<td class="price"><a href="/dashboard/view/{{$order['id']}}">{{ $order['total_price'] }} {{$cms['currency']}}</a></td>
							<td class="date">{{ $order['created_at'] }}</td>
							<td><input type="checkbox" name="orders[]" class="order_checkbox" value={{ $order['id'] }}></td>
						</tr>
					@endforeach
				@else
					<tr><td colspan="4"><br>... empty ...</td></tr>
				@endif
			</table>
			<center>
				<input type="submit" class="btn btn-primary max-auto" value="Delete">
			</center>
		</form>
	</div>
</div>

<script>
$( document ).ready(function() {
	var sel = $('input[name=select_all]');
	if (sel.length) {
		sel.click(function(){
			var status = sel.prop('checked');
			$('.order_checkbox').each(function(e){
				$(this).prop('checked', status);
			});
		});
	}
});
</script>
@endsection
