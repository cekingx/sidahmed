@extends('admin::layouts.master')

@section('title', 'Background Images')

@section('options')
<a class="ui primary button" href="javascript:void(0)" onclick='$("#create_background_file").click();'>	
	Create Background
</a>
@endsection

@section('content')

<table class="ui celled padded table mt-5">
	<thead>
		<tr>
			<th class="single line">Preview</th>
			<th>Name</th>
			<th>Options</th>
		</tr>
	</thead>
	<tbody>
		@foreach($backgrounds as $background)
		<tr class="background_image" data-background="{{$background->id}}">
			<td>
				<img src="{{$background->path}}" class="ui small image preview">
			</td>
			<td>
				{{$background->name}}
			</td>
			<td>
				<a class="ui secondary button" onclick="generatePreview({{$background->id}}, 'cities')">
					Generate in Cities
				</a>
				<a class="ui secondary button" onclick="generatePreview({{$background->id}}, 'celestial')">
					Generate in Celestial
				</a>
				<a class="ui primary button" onclick="deleteBackground({{$background->id}})">
					Delete
				</a>
			</td>
		</tr>
		@endforeach
	</tbody>
</table>

@include('admin::backgrounds.components.editor')
@endsection

@push('javascript')
<script>
	let backgrounds = {!! json_encode($backgrounds) !!};

	$(function(){
		$(".ui.dropdown").dropdown();
	})

	function generatePreview(id, type) {
		window.location.href = `{{url('/')}}/${type}?previewer=${id}`;
	}

	function deleteBackground(id) {
		if(confirm('Are you sure you want to delete this item?')) {
			$.ajax({
				url:"{{route('admin::backgrounds.delete')}}",
				type:"POST",
				data:{background_image_id: id},

				success:function(){
					$(`tr[data-background=${id}]`).hide();
				}
			});
		}
	}
</script>
@endpush