/**
 ** Handle Customize Section
 **/

function customize_setFontSize(size){ 
	editor.settings.font.size = size;
	editor.methods.updateText();
}

function customize_setCircle(type) {
	editor.settings.circle = type;
	editor.methods.updateCircleState();
}

function customize_setBorders(status) {
	editor.settings.borders = status;
	editor.methods.updateBorders();
}

function customize_setBordersSize(value) {
	editor.settings.bordersSize = value+'px';
	editor.methods.updateBorders();
}


function customize_setFontFamily(font) {
	editor.settings.font.family = font;
	editor.methods.updateText();
}

function customize_toggleText(status) {
	editor.settings.textStatus = status;
	editor.methods.updateText();
}

function finish_setTextStyle(type) {
	editor.settings.textStyle = type;
	editor.methods.updateTextStyle();
}

function customize_updateSticker(type) {
	editor.settings.sticker.type = type;
	editor.methods.updateSticker();
}

function customize_toggleSticker(status) {
	editor.settings.sticker.status = status;
	editor.methods.updateSticker();
}


$(function(){

	// Customize font

	$("#customize_fontFamily").change(function() {
		customize_setFontFamily($(this).val());
	})

	$('#customize_fontSize').range({
		min: 1,
		max: 2,
		start: 1,
		step:0.01,

		onChange: function(value, meta) {
			customize_setFontSize(value);
		}
	});

	// Init stickers UI

	$.each(editor.stickers, function(idx, meta) {
		$("#customize_stickerSettings .menu").append(`
			<a class="item" data-type="${meta}">
				<img src="${meta}">
			</a>
		`);
	});

	$("#customize_sticker").change(function(e){
		if($(this).is(':checked')) {
			customize_toggleSticker(true);
			$("#customize_stickerSettings").show();
		}
		else {
			customize_toggleSticker(false);
			$("#customize_stickerSettings").hide();
		}
	})

	$("#customize_stickerSettings").on('click', '.item', function() {
		customize_updateSticker($(this).data('type'));
	});

	// Init Text Styles UI
	$.each(editor.textStyles, function(idx, meta) {
		$("#finish_textStyles .grid").append(`
			<div class="column">
				<img src="${siteUrl}/img/cities/text_styles/${meta}.png" data-style="${meta}" class="ui style image">
			</div>
		`);
	});

	$("#finish_textStyles .grid").on('click', '.style', function(e) {
		finish_setTextStyle($(this).data('style'));
	});


	// Init slider ranges

	$('#customize_borderSize').range({
		min: 3,
		max: 10,
		start: 3,

		onChange: function(value, meta) {
			customize_setBordersSize(value);
			$("#customize_borderSizePreview").html(value+'px');
		}
	}).range('set value', parseInt(editor.settings.bordersSize));

	$("#customize_circle").on('change', function(){
		if($(this).is(':checked')) {
			customize_setCircle(true);
		}
		else customize_setCircle(false);
	})

	$("#customize_toggleText").on('change', function(){
		if($(this).is(':checked')) {
			customize_toggleText(true);
			$("#customize_textSettings").show();
		}
		else {
			customize_toggleText(false);
			$("#customize_textSettings").hide();
		}
	})

	$("#customize_borders").on('change', function(){
		if($(this).is(':checked')) {
			customize_setBorders(true);
			$("#customize_bordersSettings").show();
		}
		else {
			customize_setBorders(false);
			$("#customize_bordersSettings").hide();
		}
	})
})