<div class="ui grid">
	<div class="six wide column">
		<h2>Poster Sizes</h2>
	</div>
	<div class="ten wide column" style="text-align:right; padding-right:3rem;">
		<a class="ui primary button" onclick="posters_create_showModal()">
			Create
		</a>
	</div>
</div>

<table class="ui celled padded table">
	<thead>
		<tr>
			<th>Name</th>
			<th>Width</th>
			<th>Height</th>
			<th>Cost</th>
			<th>Settings</th>
		</tr>
	</thead>
	<tbody>
		@foreach($posterSizes as $size)
			<tr>
				<td>{{$size->name}}</td>
				<td>{{$size->width}} {{$size->unit}}</td>
				<td>{{$size->height}} {{$size->unit}}</td>
				<td>£{{$size->cost}}</td>
				<td>
					<a class="ui tiny poster edit trigger button" data-postersize="{{$size->id}}">
						Edit
					</a>
					<a class="ui primary tiny button" onclick="posters_deletePosterSize({{$size->id}})">
						Delete
					</a>
				</td>
			</tr>
		@endforeach
	</tbody>
</table>


@include('admin::invoice.posters.components.create')
@include('admin::invoice.posters.components.edit')
@include('admin::invoice.posters.components.delete')

@push('javascript')
<script>

	// Create PosterSizes Structure

	let posterSizes 		 = {!! json_encode($posterSizes) !!},
		currentPosterSize = null;

	window.setCurrentPosterSize = function(new_poster_size_id) {
		currentPosterSize = null;
		$.each(posterSizes, function(idx, poster_size) {
			if(poster_size.id == new_poster_size_id) {
				currentPosterSize = poster_size;
			}
		})
		return currentPosterSize;
	}

	window.getCurrentPosterSize = function() {
		return currentPosterSize;
	}
</script>
@endpush