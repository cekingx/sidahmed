<div class="tab" id="customize">
	<div class="ui form">
	  	<div class="grouped fields" id="customize_mapDesign">
			<label>Change map design:</label>
			<div class="field">
				<div class="ui toggle checkbox">
					<input type="radio" name="design" data-type="circle" id="customize_circleMap">
					<label for="customize_circleMap">Circular Map Design</label>
				</div>
			</div>
			<div class="field">
				<div class="ui toggle checkbox">
					<input type="radio" name="design" data-type="heart" id="customize_heartMap">
					<label for="customize_heartMap">Heart Shape Map Design</label>
				</div>
			</div>
			<div class="field">
				<div class="ui toggle checkbox">
					<input type="radio" name="design" data-type="rectangle" id="customize_rectangleMap">
					<label for="customize_rectangleMap">Rectangular Map Design</label>
				</div>
			</div>
		</div>

		<div class="grouped fields">
			<label>Change map elements:</label>
			<div class="field">
				<div class="ui toggle checkbox">
					<input type="checkbox" id="customize_whiteBackground">
					<label>White Background</label>
				</div>
			</div>
			<div class="field">
				<div class="ui toggle checkbox">
					<input type="checkbox" id="customize_borders">
					<label>Borders</label>
				</div>
			</div>

			<div class="ui stacked segment" id="customize_bordersSettings">
				<p>
					<div class="field">
						<label>Border Size</label>
						<div class="ui range" id="customize_borderSize"></div>
					</div>

					<div class="field">
						<label>Border Padding</label>
						<div class="ui range" id="customize_borderPadding"></div>
					</div>
				</p>
			</div>

			<div class="field">
				<div class="ui toggle checkbox">
					<input type="checkbox" id="customize_mapGrid">
					<label>Map Grid</label>
				</div>
			</div>
			<div class="field">
				<div class="ui toggle checkbox">
					<input type="checkbox" id="customize_constellations">
					<label>Constellation Lines</label>
				</div>
			</div>
			<div class="field">
				<div class="ui toggle checkbox">
					<input type="checkbox" id="customize_milkyWay">
					<label>Milky Way</label>
				</div>
			</div>
		</div>
	</div>
</div>