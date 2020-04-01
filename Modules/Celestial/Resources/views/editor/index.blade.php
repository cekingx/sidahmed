@extends('layouts.master', ['distraction_free' => true])

@push('head')
	<link href="{{asset('css/Celestial.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('d3-celestial/d3-celestial.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('flexi/themes.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('datepicker/datepicker.min.css')}}" rel="stylesheet" type="text/css">
	<link href="{{asset('semantic/range.css')}}" rel="stylesheet" type="text/css">
@endpush

@section('content')
	<section class="ui basic editor segment">
	    <div class="ui mobile reversed grid full-height">
	    	<div class="sixteen wide mobile five wide computer column white-background">
	    		<div class="tools" id="editor-tools">
	    			@include('celestial::editor.components.toolbox.main')
	    		</div>
			</div>
	    	<div class="column" id="preview-wrapper">
	    		@include('celestial::editor.components.canvas.main')
	    	</div>
	    </div>
	</section>
@endsection

@push('javascript')
	<script type='text/javascript' src="{{asset('d3-celestial/lib/d3.min.js')}}"></script>
	<script type='text/javascript' src="{{asset('d3-celestial/lib/d3.geo.projection.min.js')}}"></script>
	<script type='text/javascript' src="{{asset('d3-celestial/d3-celestial.min.js')}}"></script>
	<script type='text/javascript' src="{{asset('flexi/colorpicker.min.js')}}"></script>
	<script type='text/javascript' src="{{asset('datepicker/datepicker.min.js')}}"></script>
	<script type='text/javascript' src="{{asset('semantic/range.js')}}"></script>
	<script type='text/javascript' src="{{asset('js/stickykit.min.js')}}"></script>
	<script type='text/javascript' src="{{asset('js/html2canvas.js')}}"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.4.1/jspdf.debug.js" integrity="sha384-THVO/sM0mFD9h7dfSndI6TS0PgAGavwKvB5hAxRRvc0o9cPLohB0wb/PTA7LdUHs" crossorigin="anonymous"></script>
	
	<script type='text/javascript' src="{{asset('js/Celestial.js')}}"></script>

	<script>
		$(function(){
			$(".tools").stick_in_parent({
			    offset_top: 75
			});

			$(".editor .tools .headers .item").click(function(e) {
				setTimeout(function(){ $(document.body).trigger("sticky_kit:recalc") }, 2000);
			});
		})
	</script>
@endpush