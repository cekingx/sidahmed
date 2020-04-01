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

function theme_setCurrentType(type) {
	return editor.settings.colorData.selected = type;
}

$(function(){

	$("#theme_colorType").on('click', '.item', function(e) {
		let type = $(this).data('type');

		if(type) {
			theme_setCurrentType(type);
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