@extends('admin::layouts.master')

@section('title', 'Completed Orders')

@section('content')


<table class="ui celled padded table data" id="custom-order-table-data">
	<thead>
		<tr>
			<th>Order Number</th>
			<th>Order Time</th>
			<th>Poster's Links</th>
			<th>Completed At</th>
			<th>Delete</th>
		</tr>
	</thead> 
	<tbody>
		@foreach($customOrdersList as $orderInfo)
			<tr class="img-link-tr">
				<td>{{$orderInfo['order_number']}}</td>
				<td>{{$orderInfo['created_at']}}</td>
				<td>
					@if (is_array($orderInfo['orderDetailsInfo']) && count($orderInfo['orderDetailsInfo'])>0)
                    @foreach($orderInfo['orderDetailsInfo'] as $orderDetails)
					<a target="_black" href="{{route('admin::imagelinks.edit',$orderDetails['id'])}}" >{{$orderDetails['title']}}</a><br>
					@endforeach
					@endif
				</td>
				<td>{{$orderInfo['complated_at']}}</td>

				<td><a href="{{route('admin::custom-order.completed-delete',$orderInfo['id'])}}" onclick="if (confirm('Are you sure you want to delete selected order?')){return true;}else{event.stopPropagation(); event.preventDefault();};" title="Delete Order">Delete</a>
</td>
			</tr>
		@endforeach
	</tbody>
</table>

@endsection

@push('javascript')
<script type="text/javascript">
	$(document).ready(function() {
    $('#custom-order-table-data').DataTable();

    $(document).on("click",".update-expiry",function(e){
    	e.preventDefault();
    	var urlLink = $(this).attr("href");
    	var linkId = $(this).attr("linkId");
    	 $.ajax({
                        url: urlLink,
                        type: "GET",
                        async:false,
                        success: function success(response) {
                            // $("#loading").hide();
                            $("#expiry_date").val(response);
                            $("#edit_expiry").modal("show");
                            $("#image-id-current").val(linkId);
                            // $('#expiry_date').datepicker();
                            
                        }
        });
    	
    })
    $(document).on("click","#update-expire-button",function(e){
    	var currentValue = $("#expiry_date").val();
    	var linkId = $("#image-id-current").val();
    	var $this = $(this);
    	$.ajax({
                        url: "{{route('admin::imagelinks.update','')}}"+"/"+linkId,
                        type: "POST",
                        data: {expiry_date:currentValue},
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        async:false,
                        success: function success(response) {
                            // $("#loading").hide();
                            $("#expiry_date").val(response);
                            $("#edit_expiry").modal("hide");
                            // alert(currentValue);
                            // console.log(".expire-at-td"+linkId);
                            $(".expire-at-td-"+linkId).html(currentValue);
                            // $('#expiry_date').datepicker();
                            
                        }
        });
    });
} );
</script>
@endpush