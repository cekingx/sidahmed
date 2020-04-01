/**
 ** Handle Customize Section
 **/

function customize_setMapDesign(type) {
	editor.settings.design = type;
	editor.methods.updateMapDesign();
}

function customize_setWhiteBackground(status) {
	editor.settings.whitebg = status;
	editor.methods.updateComponentColors();
}

function customize_setBorders(status) {
	editor.settings.borders = status;
	editor.methods.updateBorders();
}

function customize_setBordersSize(value) {
	editor.settings.bordersSize = value+'px';
	editor.methods.updateBorders();
}

function customize_setBordersPadding(value) {
	editor.settings.bordersPadding = value+'rem';
	editor.methods.updateBorders();
}

function customize_setMapGrid(status) {
	editor.settings.grid = status;
	editor.methods.updateMap();
}

function customize_setConstellations(status) {
	editor.settings.constellations = status;
	editor.methods.updateMap();
}

function customize_setMilkyWay(status) {
	editor.settings.milkyWay = status;
	editor.methods.updateMap();
}

$(function(){

	// Init slider ranges

	$('#customize_borderSize').range({
		min: 0,
		max: 10,
		start: 3,

		onChange: function(value, meta) {
			customize_setBordersSize(value);
		}
	}).range('set value', parseInt(editor.settings.bordersSize));

	$('#customize_borderPadding').range({
		min: 0,
		max: 1.9,
		start: parseInt(editor.settings.borderPadding),
		step:0.1,

		onChange: function(value, meta) {
			customize_setBordersPadding(value);
		}
	}).range('set value', parseInt(editor.settings.bordersPadding));




	$("#customize_mapDesign").on('change', 'input', function(e){
		let $this = $(this);

		if($this.is(':checked')) {
			let type = $this.data('type');

			if(editor.settings.design == type) {
				return e.preventDefault();
			}

			if(type) {
				customize_setMapDesign(type);
			} 
		}
	})

	$("#customize_whiteBackground").on('change', function(){
		if($(this).is(':checked')) {
			customize_setWhiteBackground(true);
		}
		else customize_setWhiteBackground(false);
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

	$("#customize_mapGrid").on('change', function(){
		if($(this).is(':checked')) {
			customize_setMapGrid(true);
		}
		else customize_setMapGrid(false);
	})

	$("#customize_constellations").on('change', function(){
		if($(this).is(':checked')) {
			customize_setConstellations(true);
		}
		else customize_setConstellations(false);
	})	

	$("#customize_milkyWay").on('change', function(){
		if($(this).is(':checked')) {
			customize_setMilkyWay(true);
		}
		else customize_setMilkyWay(false);
	})	
})