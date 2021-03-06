@extends('layouts.master', ['distraction_free' => true, 'header' => false])

@push('head')
	<meta content="2048" name="Large-Allocation" />

	<link href="https://fonts.googleapis.com/css?family=Abril+Fatface|Noto+Serif+TC:900|Playfair+Display:900|Roboto:900" rel="stylesheet">
	
	<link rel="stylesheet" href="https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.css"/>
	<link href="{{asset('css/Cities.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('flexi/themes.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('datepicker/datepicker.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('semantic/range.css')}}" rel="stylesheet" type="text/css">
@endpush

@section('content')
	<section class="ui basic editor segment {{$print ? 'hidden' : ''}}">
	    <div class="ui mobile reversed grid full-height">
	    	<div class="sixteen wide mobile four wide computer column white-background screen-height" id="tools-wrapper">
	    		<div class="tools" id="editor-tools">
	    			@include('cities::editor.components.toolbox.main')
	    		</div>
			</div>
	    	<div class="sixteen wide mobile twelve wide computer column" id="preview-wrapper">
	    		@if(!$print)
	    		@include('cities::editor.components.canvas.main')
	    		@endif
	    		<div class="mobile-menu-background"></div>
	    	</div>
	    </div>
	</section>

	@if($print)
	@include('cities::editor.components.canvas.main')
	@endif
@endsection

@push('javascript')
	<script>
		@if(isset($settings))
			window.editorSettings = {!! json_encode($settings) !!};
		@else
			window.editorSettings = [];
		@endif
	</script>

	@if(Auth::check() && Auth::user()->isAdmin() && ($mode != 'etsy'))
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>
	@endif

	<script type="text/javascript" src="https://api.tiles.mapbox.com/mapbox-gl-js/v0.50.0/mapbox-gl.js"></script>
	<script type='text/javascript' src="{{asset('flexi/colorpicker.min.js')}}"></script>
	<script type='text/javascript' src="{{asset('datepicker/datepicker.min.js')}}"></script>
	<script type='text/javascript' src="{{asset('semantic/range.js')}}"></script>
	<script type='text/javascript' src="{{asset('js/stickykit.min.js')}}"></script>
	<script type='text/javascript' src="{{asset('js/html2canvas.js')}}"></script>

	<script type="text/javascript" src="//cdn.jsdelivr.net/canvas-toblob/0.1/canvas-toBlob.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/npm/filesaver.js@1.3.4/FileSaver.min.js"></script>
<script type="text/javascript" src="//cdn.jsdelivr.net/jspdf/1.3.4/jspdf.min.js"></script>

	@if($print || $mode == 'admin')
	<script>
		$("#canvas-frame").addClass('print')
		$(".mapboxgl-ctrl").hide();
		$("body").addClass('print').css('overflow','auto');
	</script>
	@endif

	@if($mode =='admin-preview')
		<form id="admin-preview-form" method="post" action="{{route('admin::preview.generate')}}" enctype="multipart/form-data">
			@csrf
			<input type="hidden" name="file" id="admin-preview-file">
			<input type="hidden" name="background" id="admin-preview-background">
		</form>
	@endif

	<script type='text/javascript' src="{{asset('js/Cities.js')}}"></script>

	@if(Auth::check() && Auth::user()->isAdmin() && ($mode == 'admin' || $mode == 'admin-preview'))
	<script>
		function adminExport(width, height) {

			// Prepare function arguments
			@if($mode == 'admin-preview')
			width = {{$background->data->size[0] / 300}} * 25.4;
			height = {{$background->data->size[1] / 300}} * 25.4;
			@else
			width = width || editor.settings.size[0];
			height = height || editor.settings.size[1];
			@endif

			bounds = editor.methods.getMapBoundaries();

			// Prepare document
			window.scrollTo(0, 0);
			$("#canvas-frame").addClass('print').parent().removeClass('canvas');
			$("#loading").show();

			console.log(`The poster size is: ${width} x ${height}`);

			console.log(`Will proceed to set the canvas to that size.`);

			// Adjust canvas
			editor.methods.setCanvasSizeAndBounds(width, height, bounds, function(){

				// Convert the canvas to an image element
				let canvasElement 	= editor.map.getCanvas(), // Find the canvas generated by MapBox
					img 			= $(`<img style="width:100%; height:auto">`); // Create the image wrapper

				console.log(`The canvas has loaded with the new size, the Base64 data is:`);

				console.log(canvasElement.toDataURL('image/png', .8));

				img.attr('src', canvasElement.toDataURL('image/png',0.8));

				// Convert the HTML to canvas and append it to a PDF file
				html2canvas($("#canvas-frame").get(0), {imageTimeout: 0, scale:1, allowTaint: true}).then(function(canvas) {

					@if($mode == 'admin-preview')
					
					$("#admin-preview-file").val(canvas.toDataURL('image/png', 1.0));
					$("#admin-preview-background").val({{$background->id}});
					$("#admin-preview-form").submit();
	                
	                @else
					
					// Create PDF
	                let doc = new jsPDF("p", "mm", editor.settings.size, true);
	                doc.deletePage(1);
	                doc.addPage(editor.settings.size[0], editor.settings.size[1]);
	                doc.addImage(canvas.toDataURL('image/png', 1.0), 'PNG', 0, 0, editor.settings.size[0], editor.settings.size[1], '', 'FAST');
	                doc.save();
	                
	                // Output as base64
	                let pdf = btoa(doc.output());         

	                $.ajax({
	                	url:"{{route('admin::orders.upload')}}",
	                	type:"POST",
	                	data:{order_id: {{$order->id}}, file: pdf},

	                	success: function() {
	                		alert('The poster has been uploaded and linked to the order.');
	                		$("#loading").hide();
	                		editor.methods.resetCanvasSize();
					        $("#canvas-frame").removeClass('print'); // Print Ready
					        $("#canvas-frame").parent().addClass('canvas');
	                	}
	                })
	                @endif
	            });

				$("#canvas-map").css('display', 'none');
				$("#canvas-map-wrapper").append(img);
			});
		}
	</script>
	@endif

	<script>
		$(function(){
			$(".tools").stick_in_parent({
			    offset_top: 15
			});

			$(".editor .tools .headers .item").click(function(e) {
				setTimeout(function(){ $(document.body).trigger("sticky_kit:recalc") }, 2000);
			});
		})
	</script>
@endpush