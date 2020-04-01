/**
 ** Handle Location Section
 **/

function location_setDigitalCopy(status) {
	editor.settings.digital = status;
	editor.events.onSettingsChange();
}

 function location_setSize(size) {

	size = size.split("X");
	editor.settings.size = [parseFloat(size[0]), parseFloat(size[1])];
	if(md.mobile() == null) {
		editor.methods.setCanvasFitScreen();
	}
}

function location_setLocation(location) {
	if(editor.settings.location != location) {
		editor.settings.location = location;
		editor.methods.updateLocation();
	}
}

function location_setMapTitle(text) {
	editor.settings.title = text;
	editor.methods.updateText();
}

function location_setSubtitleText(text) {
	editor.settings.subtitle = text;
	editor.methods.updateText();
}


function location_setLatLngStatus(status) {
	editor.settings.latlng = status;
	editor.methods.updateText();
}

function location_setLatLongText(text) {
	editor.settings.latlongText = text;
	editor.methods.updateText();
}

function location_checkout(fn) {
	editor.methods.exportPDF(fn);
}

$(function(){

	$("#location_location").change(function(){
		location_setLocation($(this).val());
	})

	$("#location_title").keyup(function(){
		location_setMapTitle($(this).val());
	})

	$("#location_subtitleText").keyup(function(){
		location_setSubtitleText($(this).val());
	})

	$("#location_latlongText").keyup(function(){
		location_setLatLongText($(this).val());
	})

	/**
	 ** Handle Location Autocomplete
	 **/

	const places = require('places.js');
	var placesAutocomplete = places({
	    appId: "plT6IM6OIH13",
	    apiKey: "9cb82217a5d887519eb983f18e39bcee",
	    container: document.querySelector('#location_location')
	});

	placesAutocomplete.on('change', function(e){
		$("#location_location").trigger('change');
	});

		// Handle Format Types & Sizes

	let standard = -1;
	$.each(editor.sizes, function(standardIndex, standardMeta) {
		$.each(standardMeta.sizes, function(sizeIndex, sizeMeta) {
			if(sizeMeta.value === editor.settings.size[0] + 'X' + editor.settings.size[1]) {
				editor.sizes[standardIndex].sizes[sizeIndex].selected = true;
				standard = standardIndex;
			}
		})
	})

	if(standard === -1) {
		standard = 0;
		editor.sizes[standard].sizes[0].selected = true;
	}

	$("#location_size").dropdown({
		values: editor.sizes[standard].sizes, 
		onChange: function(value, txt, $itm) {
			location_setSize(value);
		}
	});

	$("#location_sizeStandards").change(function(){
		let $this = $(this);
		$.each(editor.sizes, function(idx, meta){	
			if(meta.name == $this.val()) {
				meta.sizes[0].selected = true;
				location_setSize(meta.sizes[0].value);

				$("#location_size").dropdown({
					values: meta.sizes, 
					onChange: function(value, txt, $itm) {
						location_setSize(value);
					}
				});
			}
		})
	})

	$("#checkout_button").click(function(){
		let btn 	= $(this),
			notice 	= $("#checkout-warning"),
			fields  = $("#checkout-fields");

		btn.addClass('disabled loading');
		fields.hide();
		notice.show();

		editor.methods.checkout();

		/*location_checkout(function() {
			btn.removeClass('disabled loading');
			notice.hide();
			fields.show();
		});*/
	})


	$("#location_digitalCopy").change(function(){
		if($(this).is(":checked")) {
			location_setDigitalCopy(true);
		}
		else location_setDigitalCopy(false);
	})
})