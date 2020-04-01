<div class="ui tiny modal" id="preview_modal">
  	<i class="close icon"></i>
    <div class="header">
        Generate Preview
  	</div>

    <div class="content">
        <p>Click on the image you want to use as preview.</p>
    	<div class="ui equal width grid">
    		@foreach($backgroundImages as $background)
    		<div class="column">
    			<a href="#" onclick="generatePreview({{$background->id}})">
    				<img src="{{$background->path}}" style="width:100%; height: auto;">
    			</a>
    		</div>
    		@endforeach
    	</div>
	</div>
</div>