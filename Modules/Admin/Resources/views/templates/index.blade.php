@extends('admin::layouts.master')

@section('title', 'Templates')

@section('content')
<a target="_blank" href="{{route('cities::editor')}}" class="ui primary button">Create Template</a>
<table class="ui celled padded table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Type</th>
			<th>Name</th>
			<th>Access URL</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
		@foreach($templates as $template)
			<tr>
				<td>{{$template->id}}</td>
				<td>{{$template->type}}</td>
				<td>{{$template->name}}</td>
				<td>
					<a href="{{$template->getEditorUrl()}}">
						Edit Template \ Link for Public
					</a><br/>
					<a href="{{$template->getDownloadPreviewUrl()}}">
						Download Preview
					</a><br/>
					<a href="javascript:void(0);" onclick="showPreviewOptions({{$template->id}})">
						Generate Preview with Background
					</a>
				</td>
				<td><a href="{{route('admin::templates.delete',$template->id)}}" onclick="if (confirm('Are you sure you want to delete selected template?')){return true;}else{event.stopPropagation(); event.preventDefault();};" title="Link Title">Delete</a></td>
			</tr>
		@endforeach
	</tbody>
</table>

@include('admin::templates.components.preview', compact('backgroundImages'))

@endsection

@push('javascript')
<script>
	let templates = {!! json_encode($templates) !!},
		editingTemplate = -1;

	$(function(){
		$(".ui.dropdown").dropdown();
	})

	function showPreviewOptions(id) {
		editingTemplate = id;
		$("#preview_modal").modal('show');
	}

	function generatePreview(preview_id) {
		let data = null;
		$.each(templates, function(idx, template) {
			if(template.id == editingTemplate) {
				data = template;
			}
		})

		if(data) {
			var win = window.open(`{{url('/')}}/${data.type}?previewer=${preview_id}&template=${data.id}`, '_blank');
	  		win.focus();
	  	}
	}
</script>
@endpush