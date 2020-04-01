<div class="editor" id="editor">
	<div class="content">
		<img class="bg" id="background_background">
		<img class="poster" src="{{asset('img/poster_example.png')}}" id="background_poster">
	</div>


	<div class="ui save primary button" onclick="saveBackground()">
		Save Background Image
	</div>
</div>

<div class="ui tiny modal" id="modal_create">
    <div class="header">
        Create Background Image
  	</div>

    <div class="content">
    	<form class="ui form" method="POST" enctype="multipart/form-data" id="create_background_form" action="{{route('admin::backgrounds.create')}}">
	   		@csrf
	   		<input type="file" name="file" id="create_background_file" style="display:none" onchange="uploadBackground(this)">
	   		<input type="hidden" name="data" id="create_background_data">

	        <div class="field">
	        	<h4>Input the background name:</h4>

	        	<div class="ui input">
	   				<input type="text" name="name" required/>
	        	</div>
	        </div>

	        <button type="submit" class="ui primary button">
	        	Save Background Image
	        </button>
	    </form>
    </div>
</div>

@push('javascript')
<script>
	let bg_settings = {
		offset:[0.0, 0.0],
		size:[0.0, 0.0]
	};

	function uploadBackground(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				enableEditor(e.target.result);
			};
			reader.readAsDataURL(input.files[0]);
		}
	}

	function enableEditor(background_url) {
		$("body").css('overflow', 'auto');
		$("#editor").show();
		$("#background_background").attr('src', background_url);
	}

	function disableEditor(background_url) {
		$("body").attr('style', '');
		$("#editor").hide();
	}

	function saveBackground() {
		let scale = 0.3;
		let position = $("#background_poster").position(), size = [$("#background_poster").width(), $("#background_poster").height()];
		
		bg_settings.offset = [position.left / scale, position.top / scale];
		bg_settings.size = [size[0] / scale, size[1] / scale];

		disableEditor();
		$("#modal_create").modal('show');
		$("#create_background_data").val(JSON.stringify(bg_settings));
	}

</script>
@endpush