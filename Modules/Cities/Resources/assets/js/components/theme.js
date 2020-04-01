/**
 ** Handle Theme Section
 **/

function theme_setComponentColor(type, color) {
	if(color.indexOf('#') == -1) {
		color = '#' + color;
	}

	$.each(editor.settings.colorData.colors, function(idx, meta) {
		if(meta.type == type) {
			editor.settings.colorData.colors[idx].color = color;
			editor.methods.updateComponentColors();
			return;
		}
	})
}

function theme_setMapDesign(design) {
	editor.settings.design = `${siteUrl}styles/${design.toLowerCase()}.json`;
	editor.methods.updateMapDesign();
}

function theme_setCurrentType(type) {
	return editor.settings.colorData.selected = type;
}

$(function(){

	// Init Map Colors UI

	$.each(editor.designs, function(idx, meta) {
		$("#theme_map .grid").append(`
			<div class="four wide color column">
				<div style="background-color:${meta.color};" data-style="${meta.name}"></div>
			</div>
		`);
	});

	$("#theme_map .grid").on('click', '.color > div', function(e) {
		let color = $(this).data('style');


		if(color) {
			theme_setMapDesign(color);
		}
	})

	$("#theme_colorType").on('click', '.item', function(e) {
		let type = $(this).data('type');

		if(type) {
			theme_setCurrentType(type);

			if(type == "map") {
				$("#theme_map").show();	
				$("#theme_default").hide();
			}
			else {
				$("#theme_map").hide();
				$("#theme_default").show();
			}
		}			
	})

	$("#theme_colors").on('click', '.color', function(e){
		let color = $(this).data('color');

		if(color) {
			theme_setComponentColor(editor.settings.colorData.selected, color);
		}
	})


	// Init color picker

	ColorPicker(
    	document.getElementById('theme_picker'),
    	function(hex, hsv, rgb) {
      		theme_setComponentColor(editor.settings.colorData.selected, hex);

	    	$(".color-picker").find('input').val(hex);
    	}
    );
})