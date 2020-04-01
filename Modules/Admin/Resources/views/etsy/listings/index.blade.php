@extends('admin::layouts.master')

@section('title', 'Etsy Listings')

@section('content')

<table class="ui celled padded table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Title</th>
			<th>Template</th>
			<th>Delivery Type</th>
		</tr>
	</thead>
	<tbody>
		@foreach($listings as $listing)
		<tr class="listing">
			<td>
				{{$listing->listing_id}}
			</td>
			<td>
				<a href="{{$listing->url}}">
					{{$listing->title}}
				</a>
			</td>
			<td>
				<span id="listing_template_text_{{$listing->listing_id}}">
					
					@if($listing->template === null)
						No template attached.
					@else
						{{$listing->template->name}} (#{{$listing->template->id}})
					@endif
				</span>
				<a href="#" onclick="return false;" class="settings trigger" data-listing="{{$listing->listing_id}}">
					Attach template
				</a>
			</td>
			<td>
				<div class="ui selection {{$listing->template === null ? 'disabled' : ''}} dropdown">
					<input type="hidden" class="status" data-listing="{{$listing->listing_id}}">
					<i class="dropdown icon"></i>
					<div class="default uppercase">{{$listing->delivery ?? 'Delivery'}}</div>
					<div class="menu">
						@foreach(['digital', 'hybrid'] as $status)
						<div class="item uppercase">{{$status}}</div>
						@endforeach
					</div>
				</div>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@include('admin::etsy.listings.components.template')

@endsection

@push('javascript')
<script>
	$(function(){
		$(".ui.dropdown").dropdown();

		$(".status").change(function(){
			let delivery = $(this).val(),
				listing_id = $(this).data('listing');

			$(this).siblings('.default').text(delivery);
			$.ajax({
				url:"{{route('admin::etsy.listings.edit')}}",
				type:"POST",
				data:{listing_id: listing_id, delivery: delivery},

				success: function(){
					toastr.success('The delivery type has been switched to: '+delivery);
					$(".disabled").removeClass('disabled');
				}
			})
		})
	})
</script>
@endpush