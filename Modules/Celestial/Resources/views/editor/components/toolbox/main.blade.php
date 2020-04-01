<div class="ui compact labeled icon headers pointing menu">
	<a class="active item" data-tab="#location">
		<i class="map marker alternate icon"></i>
		Location
	</a>

	<a class="item" data-tab="#customize">
		<i class="eraser icon"></i>
		Customize
	</a>
	
	<a class="item" data-tab="#theme">
		<i class="pencil alternate icon"></i>
		Theme
	</a>
	
	<a class="item" data-tab="#finish">
		<i class="paper plane outline icon"></i>
		Finish
	</a>
</div>

<div class="ui segment box">
	@include('celestial::editor.components.toolbox.tabs.location')
	@include('celestial::editor.components.toolbox.tabs.customize')
	@include('celestial::editor.components.toolbox.tabs.theme')
	@include('celestial::editor.components.toolbox.tabs.finish')
</div>

@push('javascript')
<script>
	$(function(){
		$(".ui.dropdown").dropdown();
		$(".ui.checkbox").checkbox();
	})
</script>
@endpush