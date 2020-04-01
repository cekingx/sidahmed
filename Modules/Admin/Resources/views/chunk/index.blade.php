@extends('admin::layouts.master')

@section('title', 'Orders Chunk Uploader')

@push('head')
<link href="{{asset('imageuploader/imageuploader.css')}}" rel="stylesheet" type="text/css">
@endpush

@section('content')
<div id="upload-box" style="width:100%; min-height:50vh">
</div>
@endsection

@push('javascript')
<script src="{{asset('imageuploader/imageuploader.js')}}"></script>

<script>
	$(function(){
		$('#upload-box').uploader({
			fileTypeWhiteList: ['pdf'],
			instructionsCopy: "You can drag and drop too.",
			ajaxUrl: "{{route('admin::orders.chunk.upload')}}"
		});
	})
</script>
@endpush