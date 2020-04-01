<div class="tab" id="theme">
	<div class="ui form">
		<div class="field">
			<label>Change default color:</label>

			<div class="ui fluid four item menu" id="theme_colorType">
				<a class="item active" data-type="map">
					Map
				</a>
				<a class="item" data-type="text">
					Text
				</a>
				<a class="item" data-type="borders">
					Borders
				</a>
				<a class="item" data-type="poster">
					Poster
				</a>
			</div>
		</div>

		<div class="field" id="theme_map">
			<div class="ui equal width map colors grid">
			</div>
		</div>

		<div id="theme_default" style="display:none">
			<div class="field">
				<div class="ui equal width colors grid" id="theme_colors">
					<div class="column color" data-color="#000000">
						<div style="background-color:#000000"></div>
					</div>
					<div class="column color" data-color="#105176">
						<div style="background-color:#105176"></div>
					</div>
					<div class="column color" data-color="#0f1d42">
						<div style="background-color:#0f1d42"></div>
					</div>
					<div class="column color" data-color="#394456">
						<div style="background-color:#394456"></div>
					</div>
					<div class="column color" data-color="#e7304d">
						<div style="background-color:#e7304d"></div>
					</div>
				</div>
			</div>

			<div class="field" style="min-height:16rem">
				<label>Custom color:</label>

				<div class="cp cp-default" id="theme_picker"></div>
			</div>
		</div>
	</div>
</div>