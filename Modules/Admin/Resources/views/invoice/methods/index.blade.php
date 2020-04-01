<div class="ui grid">
	<div class="six wide column">
		<h2>Shipping Methods</h2>
	</div>
	<div class="ten wide column" style="text-align:right; padding-right:3rem;">
		<a class="ui primary button" onclick="methods_create_showModal()">
			Create
		</a>
	</div>
</div>

<table class="ui celled padded table">
	<thead>
		<tr>
			<th>Shipping</th>
			<th>Amount</th>
			<th>Settings</th>
		</tr>
	</thead>
	<tbody>
		@foreach($shippingMethods as $method)
		<tr>
			<td>{{$method->name}}</td>
			<td>£{{$method->cost}}</td>
			<td>
				<a class="ui tiny method edit trigger button" data-method="{{$method->id}}">
					Edit
				</a>
				<a class="ui primary tiny button" onclick="methods_deleteShippingMethod({{$method->id}})">
					Delete
				</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>


@include('admin::invoice.methods.components.create')
@include('admin::invoice.methods.components.edit')
@include('admin::invoice.methods.components.delete')

@push('javascript')
<script>
	// Create Shipping Method Structure

	let shippingMethods 		 = {!! json_encode($shippingMethods) !!},
		currentShippingMethod = null;

	window.setCurrentShippingMethod = function(new_shipping_method_id) {
		currentShippingMethod = null;
		$.each(shippingMethods, function(idx, shipping_method) {
			if(shipping_method.id == new_shipping_method_id) {
				currentShippingMethod = shipping_method;
			}
		})
		return currentShippingMethod;
	}

	window.getCurrentShippingMethod = function() {
		return currentShippingMethod;
	}
</script>
@endpush