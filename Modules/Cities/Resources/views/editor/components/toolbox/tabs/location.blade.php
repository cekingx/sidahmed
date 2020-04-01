<div class="active tab" id="location">
	<div class="ui form">
		<div class="field">
			<label>
				Location you want to see the sky from:
			</label>
			<div class="ui fluid input">
			  	<input type="text" placeholder="e.g London" id="location_location" style="width:100% !important;">
			</div>
		</div>

		<div class="field">
			<label>Change map title:</label>

			<div class="ui input">
			  	<input type="text" id="location_title">
			</div>
		</div>

		<div class="field">
			<label>Change subtitle:</label>

			<div class="ui input">
			  	<input type="text" id="location_subtitleText">
			</div>
		</div>

		<div class="field">
			<label>Change latitude/longitude text:</label>

			<div class="ui input">
				<input type="text" id="location_latlongText">
			</div>
		</div>

		@if($mode != 'etsy')
		<?php 
		/*<div class="field">
			<label>Size Standards</label>
			<select class="ui selection dropdown" id="location_sizeStandards">
				<option selected>US Sizes</option>
				<option>Metric Sizes</option>
				<option>ISO Standards</option>
			</select>
		</div>*/
		?>

		<div class="field">
			<label>Size</label>
			<select class="ui selection dropdown" id="location_size">
				@foreach($sizeLists as $sizeInfo)
				<option value="{{$sizeInfo->width.'X'.$sizeInfo->height}}" sizeValue="{{$sizeInfo->width.'X'.$sizeInfo->height}}" >{{$sizeInfo->size_name}}</option>
				@endforeach
			</select>
		<?php	/*<div class="ui selection dropdown" id="location_size">
				<div class="text"></div>
				<i class="dropdown icon"></i>
			</div>*/ ?>
		</div>
<?php
		/*<div class="ui olive message">
		  	<div class="header">
			    Do you want a digital copy? (file only)
			</div>

		  	<p>
		  		<div class="field">
		  			<div class="ui toggle checkbox">
						<input type="checkbox" id="location_digitalCopy">
						<label>Digital Copy</label>
					</div>
		  		</div>
		  	</p>
		</div>*/
?>
		@endif
	</div>
</div>