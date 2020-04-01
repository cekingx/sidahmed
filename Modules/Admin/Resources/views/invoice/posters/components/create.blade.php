<div class="ui tiny modal" id="posters_create_modal">
  	<i class="close icon"></i>
    <div class="header">
        Create Poster Size
  	</div>

    <div class="content">
        <form class="ui form" method="POST" id="posters_create_form" action="{{route('admin::poster-size.store')}}">
            @csrf

			<div class="field">
				<label>Name (optional)</label>
				<div class="ui input">
					<input type="text" name="name">
				</div>
			</div>

			<div class="field">
				<label>Unit</label>
				<select class="ui selection dropdown" name="unit">
					<option value="mm">Millimeters (mm)</option>
					<option value="cm">Centimeters (cm)</option>
					<option value="in">Inches (in)</option>
				</select>
			</div>

			<div class="field">
				<label>Width</label>
				<div class="ui input">
					<input type="number" name="width" placeholder="Introduce the width">
				</div>
			</div>

			<div class="field">
				<label>Height</label>
				<div class="ui input">
					<input type="number" name="height" placeholder="Introduce the height">
				</div>
			</div>

			<div class="field">
				<label>Cost (£)</label>
				<div class="ui input">
					<input type="number" name="cost" placeholder="Introduce the cost">
				</div>
			</div>
        </form>
    </div> 

  	<div class="actions">
        <div class="ui positive right labeled icon button" onclick="$('#posters_create_form').submit();">
            Accept
            <i class="checkmark icon"></i>
	    </div>
    </div>
</div>

@push('component_javascript')
<script>
	function posters_create_showModal() {
		$("#posters_create_modal").modal('show');
	}
</script>
@endpush