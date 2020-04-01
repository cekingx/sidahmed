@extends('admin::layouts.master')

@section('title', 'Image Links')

@section('content')


<table class="ui celled padded table data" id="link-table-data">
	<thead>
		<tr>
			<th>Link Number</th>
			<th>Link</th>
			<th>Order Number</th>
			<th>Created at</th>
			<th>Expire On</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
		@foreach($imageLinkList as $linkInfo)
			<tr class="img-link-tr">
				<td>{{$linkInfo->id}}</td>
				<td>{{$tempImagesLinksModel->getLinktoImage($linkInfo->token)}}</td>
				<td>{{$linkInfo->order_number}}</td>
				<td>{{date("Y-m-d",strtotime($linkInfo->created_at) )}}</td>
				<td class="expire-at-td-{{$linkInfo->id}}">{{date("Y-m-d",strtotime($linkInfo->expire_at) )}}</td>
				<td><a class="update-expiry" linkId="{{$linkInfo->id}}" href="{{route('admin::imagelinks.edit',$linkInfo->id)}}" >Edit</a></td>
				<td><a href="{{route('admin::imagelinks.delete',$linkInfo->id)}}" onclick="if (confirm('Are you sure you want to delete selected link?')){return true;}else{event.stopPropagation(); event.preventDefault();};" title="Link Title">Delete</a>
</td>
			</tr>
		@endforeach
	</tbody>
</table>

<div class="ui tiny modal" id="edit_expiry">
	<i class="close icon"></i>
	<div class="header edit_expiry">
		Image Link
	</div>

	<div class="content">
		
			<div class="field">
				<label>Expire Date</label>
				<div class="ui fluid input">
					<input type="date" id="expiry_date"  value="" name="expiry_date" >
				</div>
			</div>
			<input type="hidden" id="image-id-current">
	</div>
	<div class="actions">
		<div class="ui green deny button" id="update-expire-button">
			Update
		</div>
		<div class="ui black deny button">
			Close
		</div>

	</div>
</div>

@endsection

@push('javascript')
<script type="text/javascript">
	$(document).ready(function() {
    $('#link-table-data').DataTable({
        /* No ordering applied by DataTables during initialisation */
        "order": []
    });

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