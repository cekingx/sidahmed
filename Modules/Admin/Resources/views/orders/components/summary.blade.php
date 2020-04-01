<table class="ui celled padded table">
	<thead>
		<tr>
			<th>Time</th>
			<th>Poster</th>
			<th>Shipping</th>
			<th>Invoice Amount</th>
		</tr>
	</thead>
	<tbody>
		@foreach($summary as $idx => $month)
		<tr>
			<td>{{date('F', mktime(0,0,0, $idx, 10))}}</td>
			<td>£{{$month['poster']}}</td>
			<td>£{{$month['shipping']}}</td>
			<td>£{{$month['poster'] + $month['shipping']}}</td>
		</tr>
		@endforeach
	</tbody>
</table>
