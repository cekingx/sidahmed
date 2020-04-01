@extends('admin::layouts.master')

@section('title', 'Orders')

@section('content')
<table class="ui celled padded table">
	<thead>
		<tr>
			<th>Poster Type</th>
			<th>Delivery</th>
			<th>Quantity</th>
			<th>Poster Size</th>
			<th>File ID</th>
			<th>Customer</th>
			<th>Shipping Method</th>
			<th>Shipping</th>
			<th>Tracking Code</th>
			<th>Status</th>
			<th>Other</th>
			<th>Invoice Amount</th>
		</tr>
	</thead>
	<tbody>
		@foreach($orders as $order)
		<tr class="order" data-status="{{$order->status}}" data-type="{{$order->digital}}">
			<td>
				{{$order->type}}<br/>
			</td>
			<td>
				{{$order->digital ? 'Digital' : 'Print'}}<br/>
			</td>
			<td>
				{{$order->quantity}}
			</td>
			<td>
				@if(!empty($order->data))
					@if(!empty($order->size_name))
						{{$order->size_name}}<br/>
					@elseif(!empty($order->data->size) && $order->data->size[0] != 0)
					{{round($order->data->size[0] * 0.0393701, 2)}}in x {{round($order->data->size[1] * 0.0393701, 2)}}in<br/>
					@else
					undefined
					@endif
				@else
				undefined
				@endif
			</td>
			<td>
				@if(!empty($order->download))
				<div class="field">
					<div class="ui mini input">
						<input type="text" placeholder="Insert file name.." onchange="order_updateFileName(this)" data-order="{{$order->id}}" value="{{str_replace('.pdf', '', $order->download)}}">
					</div>
				</div>
				@else
					No file
				@endif
			</td>
			<td>
				{{$order->customer->name}}
			</td>
			<td>
				@if($shippingMethods->count())
				<div class="field">
					<select class="ui selection method dropdown" data-order="{{$order->id}}">
						<option {{!$order->shipping_method_id ? 'selected' : ''}} disabled value="">Select a shipping method</option> 
						@foreach($shippingMethods as $method)
							<option value="{{$method->id}}" {{$method->id == $order->shipping_method_id ? 'selected' : ''}}>
								{{$method->name}}
							</option>
						@endforeach
					</select>
				</div>
				@else
				No shipping methods available.
				@endif
			</td>
			<td>
				{{$order->customer->name}}<br/>
				{!! $order->shipping !!}
			</td>
			<td>
				@if(!$order->digital)
				<div class="field">
					<div class="ui mini input">
						<input type="text" placeholder="Insert tracking code.." onchange="order_updateShippingCode(this)" data-order="{{$order->id}}" value="{{$order->shipping_code}}">
					</div>
				</div>
				@endif
			</td>
			<td>
				<div class="ui mini selection {{$order->etsy_transaction && !$order->etsy_verified ? 'disabled' : ''}} dropdown">
					<input type="hidden" class="status" data-order="{{$order->id}}">
					<i class="dropdown icon"></i>
					<div class="default">{{strtoupper($order->status)}}</div>
					<div class="menu">
						@foreach([
							'unprocessed' => 'unprocessed', 
							'processed' => 'processed', 
							'printing' => 'printing', 
							'shipped' => 'shipped / file created',
							'waiting_approval' => 'waiting approval'] as $value => $key)
						<div class="item" data-value="{{$value}}" data-text="{{strtoupper($key)}}">{{strtoupper($key)}}</div>
						@endforeach
					</div>
				</div>
			</td>
			<td>
				@if($order->etsy_transaction && !$order->etsy_verified || empty($order->data))
				@else
				<a href="javascript:void(0)" onclick="data_showModal({{$order->id}})">
					<i class="info circle large icon"></i>
				</a>
				@endif
				<br/>
				<a href="javascript:void(0)" onclick="comments_showModal({{$order->id}})">
					<i class="wechat large icon"></i>
				</a>

				<a href="javascript:void(0)" class="edit trigger" data-order="{{$order->id}}">
					<i class="edit large icon"></i>
				</a>
			</td>
			<td>
				@if(!$order->digital)
				£{{$order->poster_cost + $order->shipping_cost}}
				@endif
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@include('admin::orders.components.summary', ['summary' => $summary])

@include('admin::orders.components.settings')
@include('admin::orders.components.data')
@include('admin::orders.components.customer')
@include('admin::orders.components.edit')
@include('admin::orders.components.comments')
@include('admin::orders.components.sort')

@endsection

@push('javascript')
<script>
	// Handle Status Dropdown
	$(".status").change(function(e) {
		let order = $(this).data('order'), status = $(this).val();

		$(this).siblings('.default').text(status).closest('.order').attr('data-status', status);

		$.ajax({
			url:"{{route('admin::orders.edit', ['order' => 'XX'])}}".replace('XX', order),
			type:"POST",
			data:{status: status}
		})

		sortTable();
	})

	// Handle Method Profile dropdown
	$(".method.dropdown").change(function(){
		let order = $(this).data('order'), method = $(this).dropdown('get value');

		$.ajax({
			url:"{{route('admin::orders.edit', ['order' => 'XX'])}}".replace('XX', order),
			type:"POST",
			data:{shipping_method_id: method}
		})
	})
</script>

<script>

	// Create Orders Structure

	let orders 		 = {!! json_encode($orders) !!},
		currentOrder = null;

	window.setCurrentOrder = function(new_order_id) {
		currentOrder = null;
		$.each(orders, function(idx, order) {
			if(order.id == new_order_id) {
				currentOrder = order;
			}
		})
		return currentOrder;
	}

	window.getCurrentOrder = function() {
		return currentOrder;
	}

	// Functionality

	function order_updateShippingCode(input) {

		let $this = $(input);
		$.ajax({
			url:"{{route('admin::orders.edit', ['order' => 'XX'])}}".replace('XX', $this.data('order')),
			type:"POST",
			data:{shipping_code: $this.val()},

			success:function(){
				toastr.success('The tracking code has been successfully updated.');
			}
		})
	}

	function order_updateFileName(input) {

		let $this = $(input);
		$.ajax({
			url:"{{route('admin::orders.edit', ['order' => 'XX'])}}".replace('XX', $this.data('order')),
			type:"POST",
			data:{file: $this.val()},

			success:function(){
				toastr.success('The file name has been successfully updated.');
			}
		})
	}

	// Utils

	window.populateElements = function(fields) {
        $.each(fields, function(index, field) {
            if(field.element.parent().hasClass('dropdown')) {
                field.element.dropdown("set selected", field.value);
            }
            if(field.element.is(':checkbox')) {
            	field.element.prop('checked', field.value);
            }
            else {
                field.element.val(field.value);
            }
        });   
    }
</script>
@endpush