<div class="tab" id="customize">
	<div class="ui form">
		<div class="grouped fields">
			<label>Adjust settings:</label>

			<div class="field">
				<div class="ui toggle checkbox">
					<input type="checkbox" id="customize_circle">
					<label>Circular Design</label>
				</div>
			</div>
			
			<div class="field">
				<div class="ui toggle checkbox">
					<input type="checkbox" id="customize_toggleText">
					<label>Turn off Labels</label>
				</div>
			</div>

			<div class="ui segment" id="customize_textSettings">
				<div class="field text-styles" id="finish_textStyles">
					<label>Change text style:</label>
					<div class="ui equal width grid">
					</div>
				</div>
			</div>

			<div class="field">
				<div class="ui toggle checkbox">
					<input type="checkbox" id="customize_sticker">
					<label>Sticker</label>
				</div>
			</div>

			<div class="ui segment" id="customize_stickerSettings" style="display:none">
				<div class="ui fluid three item menu">
				</div>
			</div>

			<div class="field">
				<div class="ui toggle checkbox">
					<input type="checkbox" id="customize_borders">
					<label>Borders</label>
				</div>
			</div>
          <?php 
			/*<div class="ui segment" id="customize_bordersSettings">
				<p>
					<div class="field">
						<label>Border Size <small>(<span id="customize_borderSizePreview">3px</span>)</small></label>
						<div class="ui range" id="customize_borderSize"></div>
					</div>
				</p>
			</div>*/
			?>

			<div class="field">
				<label>Select a font family</label>
				<div class="ui selection dropdown">
					<input type="hidden" id="customize_fontFamily">
					<i class="dropdown icon"></i>
					<div class="default text">Font Family</div>
					<div class="menu">
						<div class="item" data-value="Roboto">Rocky I</div>
						<div class="item" data-value="Abril Fatface">Rocky II</div>
						<div class="item" data-value="Playfair Display">Rocky III</div>
						<div class="item" data-value="Noto Serif TC">Rocky IV</div>
						<div class="item" data-value="Open Sans">Rocky V</div>
					</div>
				</div>
			</div>

			<div class="field">
				<label>Adjust font size</label>
				<div class="ui range" id="customize_fontSize"></div>
			</div>
		</div>
	</div>
</div>