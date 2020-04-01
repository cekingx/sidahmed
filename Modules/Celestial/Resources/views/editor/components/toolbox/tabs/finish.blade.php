<div class="tab" id="finish">
	<div class="ui form">

		<div class="ui icon message" id="checkout-warning" style="display:none">
			<i class="notched circle loading icon"></i>
			<div class="content">
				<div class="header">
					Just one second
				</div>
				<p>
					The gears are turning your poster into reality in this precise moment. Please stand by, it might take a moment.
				</p>
			</div>
		</div>

		<div id="checkout-fields">
			<div class="field">
				<label>Change map title:</label>

				<div class="ui input">
				  	<input type="text" id="finish_title">
				</div>
			</div>

			<div class="field">
				<label>Edit location text (won't change the map):</label>

				<div class="ui input">
				  	<input type="text" id="finish_customLocationText">
				</div>
			</div>

			<div class="field">
				<label>Edit date text (won't change the map):</label>

				<div class="ui input">
				  	<input type="text" id="finish_customDateText">
				</div>
			</div>

			<div class="field">
				<div class="ui toggle checkbox">
					<input type="checkbox" id="finish_latlng">
					<label>Latitude & Longitude</label>
				</div>
			</div>

			<div class="fields">
				<div class="field">
					<label>Size Standards</label>
					<select class="ui selection dropdown" id="finish_sizeStandards">
						<option selected>US Sizes</option>
						<option>Metric Sizes</option>
						<option>ISO Standards</option>
					</select>
				</div>

				<div class="field">
					<label>Size</label>
					<div class="ui selection dropdown" id="finish_size">
						<div class="text"></div>
						<i class="dropdown icon"></i>
					</div>
				</div>
			</div>

			<div class="ui olive message">
			  	<div class="header">
				    Do you want a digital copy? (file only)
				</div>

			  	<p>
			  		<div class="field">
			  			<div class="ui toggle checkbox">
							<input type="checkbox" id="finish_digitalCopy">
							<label>Digital Copy</label>
						</div>
			  		</div>
			  	</p>
			</div>
		</div>

		<div class="field">
			<button class="ui positive huge fluid button" id="checkout">
				<i class="cart icon"></i>
			  	Checkout
			</button>
		</div>
	</div>
</div>

@push('javascript')
<script>
</script>
@endpush