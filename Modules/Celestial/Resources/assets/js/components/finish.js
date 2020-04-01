function finish_setMapTitle(text) {
	editor.settings.title = text;
	editor.methods.updateText();
}

function finish_setCustomLocationText(text) {
	editor.settings.customLocation = text;
	editor.methods.updateText();
}

function finish_setCustomDateText(text) {
	editor.settings.customDate = text;
	editor.methods.updateText();
}

function finish_setLatLngStatus(status) {
	editor.settings.latlng = status;
	editor.methods.updateText();
}

function finish_setSize(size) {

	size = size.split("X");
	editor.settings.size = [parseFloat(size[0]), parseFloat(size[1])];
}

function finish_setDigitalCopy(status) {
	editor.settings.digital = status;
	editor.events.onSettingsChange();
}


function finish_checkout(fn) {
	editor.methods.exportPDF(fn);
}

$(function(){

	$("#checkout").click(function(){
		let btn 	= $(this),
			notice 	= $("#checkout-warning"),
			fields  = $("#checkout-fields");

		btn.addClass('disabled loading');
		fields.hide();
		notice.show();

		finish_checkout(function() {
			btn.removeClass('disabled loading');
			notice.hide();
			fields.show();
		});
	})

	$("#finish_title").keyup(function(){
		finish_setMapTitle($(this).val());
	})

	$("#finish_customLocationText").keyup(function(){
		finish_setCustomLocationText($(this).val());
	})

	$("#finish_customDateText").keyup(function(){
		finish_setCustomDateText($(this).val());
	})

	$("#finish_latlng").change(function(){
		if($(this).is(":checked")) {
			finish_setLatLngStatus(true);
		}
		else finish_setLatLngStatus(false);
	})

	$("#finish_digitalCopy").change(function(){
		if($(this).is(":checked")) {
			finish_setDigitalCopy(true);
		}
		else finish_setDigitalCopy(false);
	})

	// Handle Format Types & Sizes

	let standard = -1;
	$.each(editor.settings.sizes, function(standardIndex, standardMeta) {
		$.each(standardMeta.sizes, function(sizeIndex, sizeMeta) {
			if(sizeMeta.value === editor.settings.size[0] + 'X' + editor.settings.size[1]) {
				editor.settings.sizes[standardIndex].sizes[sizeIndex].selected = true;
				standard = standardIndex;
			}
		})
	})

	if(standard === -1) {
		standard = 0;
		editor.settings.sizes[standard].sizes[0].selected = true;
	}

	$("#finish_size").dropdown({
		values: editor.settings.sizes[standard].sizes, 
		onChange: function(value, txt, $itm) {
			finish_setSize(value);
		}
	});

	$("#finish_sizeStandards").change(function(){
		let $this = $(this);
		$.each(editor.settings.sizes, function(idx, meta){	
			if(meta.name == $this.val()) {
				meta.sizes[0].selected = true;
				finish_setSize(meta.sizes[0].value);

				$("#finish_size").dropdown({
					values: meta.sizes, 
					onChange: function(value, txt, $itm) {
						finish_setSize(value);
					}
				});
			}
		})
	})
})