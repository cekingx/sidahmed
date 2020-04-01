<div class="mobile-menu-close">Click to View Poster</div>

@include('cities::editor.components.toolbox.tabs.admin')

<div class="ui compact labeled icon headers pointing menu">
	<a class="active item" data-tab="#location">
		<i class="map marker alternate icon"></i>
		Location
	</a>

	<a class="item" data-tab="#customize">
		<i class="eraser icon"></i>
		Customise
	</a>
	
	<a class="item" data-tab="#theme">
		<i class="pencil alternate icon"></i>
		Theme
	</a>
</div>

<div class="ui segment box">
	@include('cities::editor.components.toolbox.tabs.location')
	@include('cities::editor.components.toolbox.tabs.customize')
	@include('cities::editor.components.toolbox.tabs.theme')
</div>


<div class="space"></div>

@if($mode == 'etsy')
<form id="checkout_form" action="{{route('cities::process.etsy')}}" method="POST">
@else
<form id="checkout_form" action="{{route('cities::process')}}" method="POST">
@endif
	@csrf
	<input type="hidden" id="checkout_settings" name="settings"/>
	<input type="hidden" id="checkout_preview" 	name="preview"/>
</form>
@if($countOfCart > 0)
<a title="Go to Cart" href="{{route('cart')}}" class="ui green button"> <i class="shopping cart icon"></i> {{$countOfCart}}</a>
@endif

@if(Auth::check() && Auth::user()->isAdmin() && ($mode == 'admin'))
<button class="ui positive huge fluid checkout button" onclick="adminExport()">
	Generate File
</button>
@elseif(Auth::check() && Auth::user()->isAdmin() && ($mode == 'admin-preview'))
<button class="ui positive huge fluid checkout button" onclick="adminExport()">
	Generate Preview
</button>
@elseif(Auth::check() && Auth::user()->isAdmin() && ($mode != 'etsy'))
<div class="download-btn-group">

<button class="ui positive huge fluid download-img-file download button" id="download-img-file">
	Download
</button>
<button class="ui positive huge fluid link-img-file download button" id="download-link-img">
	Download Link
</button>
</div>
{{-- <div class="n">
	<button class="ui positive huge fluid download-img-file download button" id="test-download">
		TestD
	</button>
	</div> --}}
@else
<button class="ui positive huge fluid checkout button" id="checkout_button">
	Save
</button>
@endif

@if(Auth::check() && Auth::user()->isAdmin() && ($mode != 'etsy'))
<div class="ui tiny modal" id="imgLink_modal">
	<i class="close icon"></i>
	<div class="header img_link">
		Image Link
	</div>

	<div class="content">
		<div id="copied-to-clipbord-msg" class="ui success message" style="display: none">
		      <!-- <i class="close icon close-copie"></i> -->
		      <div class="header">
		        URL copied to clipboard
		      </div>
    	</div>
			<div class="field">
				<label>Link</label>
				<div class="ui fluid input">
					<input type="text" id="image_link_copy" readonly="true" value="" name="image_link_copy" ><div class="ui green deny button" id="copy_to_clip">
			Copy
		</div>
				</div>
			</div>
	</div>
	<div class="actions">
		<div class="ui black deny button">
			Close
		</div>

	</div>
</div>
<style type="text/css">
.download-btn-group{
	text-align: center;
    position: fixed;
    bottom: 0;
}
	.tools .download.button, #editor-tools .download.button {
    position: relative;
    bottom: 0;
    left: 0;
    width: auto !important;
    display: inline-block !important;
}
</style>
@endif

@push('javascript')
<script>
	$(function(){
		$(".ui.dropdown").dropdown();
		$(".ui.checkbox").checkbox();

	})

</script>
@endpush