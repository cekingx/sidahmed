@extends('admin::layouts.master')

@section('title', 'Sizes')

@section('content')
<a href="{{route('admin::sizes.create')}}" class="ui primary button">Create Sizes</a>

<table class="ui celled padded table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Name</th>
			<th>Width(mm)</th>
			<th>Height(mm)</th>
			<th>Edit</th>
			<th>Delete</th>
		</tr>
	</thead>
	<tbody>
		@foreach($sizeList as $sizeInfo)
			<tr>
				<td>{{$sizeInfo->id}}</td>
				<td>{{$sizeInfo->size_name}}</td>
				<td>{{$sizeInfo->width}}</td>
				<td>{{$sizeInfo->height}}</td>
				<td><a href="{{route('admin::sizes.edit',['id' => $sizeInfo->id])}}" >Edit</a></td>
				<td><a href="{{route('admin::sizes.delete',$sizeInfo->id)}}" onclick="if (confirm('Are you sure you want to delete selected size?')){return true;}else{event.stopPropagation(); event.preventDefault();};" title="Link Title">Delete</a>
</td>
			</tr>
		@endforeach
	</tbody>
</table>


@endsection

@push('javascript')

@endpush