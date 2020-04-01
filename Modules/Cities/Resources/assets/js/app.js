const moment = require('moment');

const sizes = require('./components/sizes');

const utils = require('./components/utils');

import interact from 'interactjs'

const MobileDetect = require('mobile-detect');
window.md = new MobileDetect(window.navigator.userAgent);


const mapTilerAccessToken = "ZPrGlimMrAg6xmsV09Fr";
//mapboxgl.accessToken = 'pk.eyJ1IjoibWVjYXVyaW8iLCJhIjoiY2pwaGx6YWY3MHh5MzNwcnVvZXQ3bTVjdSJ9.-dTMjoFQo82N-sxb3jsDqQ';
mapboxgl.accessToken = 'pk.eyJ1IjoiYWZ3YWxsIiwiYSI6ImNqN242YmZubDJ0cHIzM251NnE3NWp0M28ifQ.GF5L8mJnxmD42rd_Iv3AKg';

const designs = [
	{name: "Minimal", 	color: "#fff"},
	{name: "Navy",	 	color: "rgb(26, 53, 65)"},
	{name: "Mint",	 	color: "rgb(121, 228, 205)"},
	{name: "Orange", 	color: "rgb(253, 82, 37)"},
	{name: "Pink",	 	color: "rgb(239, 164, 195)"},
	{name: "Red",	 	color: "rgb(198, 16, 0)"},
	{name: "Yellow", 	color: "rgb(252, 207, 42)"},
	{name: "Black", 	color: "#000"}
];

const stickers = [
	siteUrl + "img/cities/stickers/location.png",
	siteUrl + "img/cities/stickers/home.png",
	siteUrl + "img/cities/stickers/heart.png",
];

const textStyles = ['simple-right', 'simple-center', 'simple-left', 'simple-top', 'lines-center'];

 /**
  ** Parse URL parameters
  **/

window.editorSettings = $.extend(utils.getAllUrlParams(window.location.href), window.editorSettings);

/**
 ** Main Editor Data Structure
 **/

window.editor = {

	settings: $.extend({
		title: '', // Frame Title

		location: 'San Francisco, CA, USA', // Geo-location name

		subtitle: '', // Custom subtitle text (doesn't change charts)

		size: [215.9, 279.4], // Determines the poster size [width, height]

		lat: '37.728768756556406', // Position

		lng: '-122.45067482655782', // Position

		zoom: 11, // Default zoom

		zoomStep: 1,

		//design: `${siteUrl}tiles/${designs[0].name.toLowerCase()}.json`, // default JSON style

//		design: 'mapbox://styles/mecaurio/cjsaduak30vjh1gmxwgpwj1wm',

		design: `${siteUrl}styles/${designs[0].name.toLowerCase()}.json`,

		sticker: {
			type: stickers[0],
			status: false
		},

		bounds: null,

		textStatus: true, // Show/hide bottom text

		borders: true, // Display frame borders (false | true)

		bordersSize: '3px', // Default border size
		
		latlng: true, // Display latitude and longitude position (false | true)

		latlongText:'',
		
		digital: false, // Export digital download file or not

		circle: false, // Circle Style or not

		textStyle: 'simple-center',

		font: {
			family: 'Roboto',
			size: '1' // This is a multiplier
		},
		
		colorData: {
			selected: "poster", 
			colors: [
				{type: "poster",	color: "#ffffff"},
				{type: "text", 		color: "#000000"},
				{type: "borders", 	color: "#000000"}
			]
		},

		etsy: '',

		templateData: []
	}, window.editorSettings),

	sizes: sizes,

	designs: designs,

	textStyles: textStyles,

	map: null,

	stickers: stickers,

	events: {
		onTextChange: function() {

		},

		onComponentColorChange: function() {

		},

		onSettingsChange: function() {

		},

		onLocationChange: function() {
			editor.map.flyTo({center: [editor.settings.lng, editor.settings.lat], zoom: editor.settings.zoom});
		},

		onCustomMessageChange: function() {

		},

		onDesignChange: function() {

		}
	},

	methods: {

		updateAll:function() {
			editor.methods.updateText();
			editor.methods.updateMapDesign();
			editor.methods.updateComponentColors();
			editor.methods.updateCircleState();
			editor.methods.updateTextStyle();
		},

		updateSticker: function() {
			if(editor.settings.sticker.status === true) {
				$("#canvas-sticker").show();
				$("#canvas-sticker").attr('src', editor.settings.sticker.type);
			}
			else $("#canvas-sticker").hide();
		},

		updateTextStyle: function() {
			$("#canvas-bottom").attr('class', '');
			$("#canvas-bottom").addClass(editor.settings.textStyle);
			editor.methods.updateText();
		},

		updateCircleState: function() {

			if(editor.settings.circle === true) {
				let controls = $(".mapboxgl-control-container");

				$("#canvas-frame").addClass('circle');

				if(controls.hasClass('inside') || (!controls.hasClass('outside') && !controls.hasClass('inside'))) {
					controls.insertAfter($("#canvas-map-wrapper")).removeClass('inside').addClass('outside');
				}
			}
			else {
				let controls = $(".mapboxgl-control-container");

				$("#canvas-frame").removeClass('circle');

				if(controls.hasClass('outside') || (!controls.hasClass('outside') && !controls.hasClass('inside'))) {
					controls.insertAfter($(".mapboxgl-canvas-container")).removeClass('outside').addClass('inside');
				}
			}

			editor.map.resize();
		},

		updateBorders: function() {
			let elm = $("#canvas-frame");
			if(editor.settings.borders === false) {
				elm.addClass('noborder');
			}
			else {
				elm.removeClass('noborder');

				elm.css('border-width', editor.settings.bordersSize);
			}

			if(editor.map !== null) {
				editor.map.resize();
			}
		},

		updateMapDesign: function() {
			editor.map.setStyle(editor.settings.design);
		},

		updateEditorFields: function() {

			/**
			 ** Initialize the data visually
			 **/
			$("#location_location").val(editor.settings.location);
			$("#location_message").val(editor.settings.message);

			$.each($("#customize_mapDesign"), function(idx, meta) {
				if($(this).attr('value') == editor.settings.design) {
					$(this).prop('checked', true);
					return;
				}
			});

			$("#customize_borders").prop('checked', editor.settings.borders);
			$("#customize_mapGrid").prop('checked', editor.settings.grid);
			$("#customize_constellations").prop('checked', editor.settings.constellations);
			$("#customize_milkyWay").prop('checked', editor.settings.milkyWay);
			$("#customize_toggleText").prop('checked', editor.settings.textStatus);

			let divisions = editor.settings.location.split(',');

			$("#location_subtitleText").val('');

			if(editor.settings.title.length > 0) {
				$("#location_title").val(editor.settings.title);
			}
			else $("#location_title").val(divisions[0]);

			if(editor.settings.subtitle.length > 0) {
				$("#location_subtitleText").val(editor.settings.subtitle);
			}
			else {
				if(divisions.length > 1) {
					if(divisions[divisions.length-1]) {
						let subtitle = divisions[divisions.length-1].replace('USA', 'United States of America').replace('UK', 'United Kingdom');
						$("#location_subtitleText").val(subtitle);
					}
				}
			}

			$("#location_latlng").prop('checked', editor.settings.latlng);
			$("#finish_digitalCopy").prop('checked', editor.settings.digital);
		},

		updateComponentColors: function() {
 
			// Map array for easier manipulation
			let colors = [], frame = '';
			$.each(editor.settings.colorData.colors, function(index, meta) {
				colors[meta.type] = meta.color;
			});

		
			$('#canvas-border').css('border-color', ''+colors.borders+'');
			$('#canvas-wrapper').css('border-color', ''+colors.borders+'');

			// Change text color
			$('#canvas-txt').children().css('color', ''+colors.text+'');			

			// Change frame color
			$("#canvas-frame").css("background-color",''+colors.poster+'');
			$("#canvas-wrapper").css("background-color",''+colors.poster+'');
			$("#canvas-map-wrapper").css("background-color",''+colors.poster+'');
			//$("#canvas-txt").css("background-color",''+colors.poster+'');

			editor.events.onComponentColorChange();
		},

		updateText: function(){

			if(editor.settings.textStatus === false) {
				$("#canvas-bottom").css('opacity', 0);
			}
			else {
				let divisions = editor.settings.location.split(',');

				$("#canvas-subtitle").text('');

				if(editor.settings.title.length > 0) {
					$("#canvas-title").text(editor.settings.title);
				}
				else $("#canvas-title").text(divisions[0]);

				$("#canvas-txt").children().attr('style', '');
				$("#canvas-title").css('font-family', editor.settings.font.family);
				$("#canvas-title").css('font-size', parseFloat($("#canvas-title").css('font-size')) * editor.settings.font.size);
				editor.methods.updateComponentColors();

				if(editor.settings.subtitle.length > 0) {
					$("#canvas-subtitle").text(editor.settings.subtitle);
				}
				else {
					if(divisions.length > 1) {
						if(divisions[divisions.length-1]) {
							let subtitle = divisions[divisions.length-1].replace('USA', 'United States of America').replace('UK', 'United Kingdom');
							$("#canvas-subtitle").text(subtitle);
						}
					}
				}
				

				if(editor.settings.latlng === false) {
					$("#canvas-latlong").hide();
				}
				else {
					$("#canvas-latlong").show();
					
					if(editor.settings.latlongText.length > 0) {
						$("#canvas-latlong").text(editor.settings.latlongText);
					}
					else {
						let lat = editor.settings.lat, lng = editor.settings.lng, latd = '', lngd = '';

						latd = (lat < 0) ? 'S' : 'N';
						lngd = (lng < 0) ? 'W' : 'E';

						$('#canvas-latlong').html(Math.abs(lat).toFixed(2)+'&deg;'+latd+'&nbsp;|&nbsp;'+Math.abs(lng).toFixed(2)+'&deg;'+lngd);
					}
				}

				$("#canvas-bottom").css('opacity', 1);
				editor.events.onTextChange();
			}
		},

		updateLocation: function(){
			delete $.ajaxSettings.headers["X-CSRF-TOKEN"]; // Remove header before call

			$.ajax({
				type: "GET",
				dataType: "json",
				url: "https://maps.googleapis.com/maps/api/geocode/json",
				data: {'address': editor.settings.location, 'sensor':false, 'key':'AIzaSyDcMmi7sQFB1D5-U-sBptyBkRhZr-WMSJw'},

				success: function(data){
					let lat = data.results[0].geometry.location.lat,
						lng = data.results[0].geometry.location.lng;

					editor.settings.lat = lat;
					editor.settings.lng = lng;
					editor.settings.zoom = 11;
					editor.settings.location = data.results[0].formatted_address;
					editor.methods.updateText();
					editor.events.onLocationChange();
					editor.methods.updateEditorFields();

					$.ajaxSetup({
		    			headers: {
					        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					    }
					});
				}
			});
		},

		updateMapDesign: function() {

			if (editor.settings.design.indexOf('tilehosting') >= 0) editor.settings.design += '?key=' + mapTilerAccessToken;
        	editor.map.setStyle(editor.settings.design);
		},

		resetCanvasSize: function() {
			$("#canvas-frame").attr('style', '');
			$("#canvas-txt").attr('style', '');
			$("#canvas-map-wrapper").attr('style', '');
			$("#canvas-border").attr('style', '');
			$("#canvas-wrapper").attr('style', '');
			editor.map.setZoom(11);
			editor.map.resize();
			editor.methods.updateAll();
		},

		getMapBoundaries: function() {

			if(editor.map) {
				// Get bounding box
				let map = editor.map,
					mapCanvas = map.getCanvas(),
					w = mapCanvas.width,
					h = mapCanvas.height,
					cUL = map.unproject([0,0]).toArray(),
					cLR = map.unproject([w,h]).toArray();

				return [cUL, cLR];
			}
		},

		setCanvasSize: function(width, height, onload_function) {

			onload_function = onload_function || null;

			let mmSize = [width, height];
			
			// Convert the width and height, from mm to inches
			width  *= 0.0393701;
			height *= 0.0393701;

			// Convert into pixels @ 300 DPI
			width  *= 300;
			height *= 300;

			// Calculate font sizes and stuff by areas differences
			let previewArea  = parseFloat($("#canvas-frame").css('width')),
				totalArea    = previewArea * parseFloat($("#canvas-frame").css('height')),
				newArea 	 = width;

			$("#canvas-frame").attr('style', 'display:block;').css('width', width + 'px').css('height', height + 'px').css('padding', '1.9cm');
			$("#canvas-wrapper").css('padding', '.5cm');

			$("#canvas-wrapper").css('border-width', ((parseFloat($("#canvas-wrapper").css('border-width')) * newArea) / previewArea) * 2);
			$("#canvas-border").css('border-width', (parseFloat($("#canvas-border").css('border-width')) * newArea) / previewArea);

			if(editor.map) {
				editor.map.resize();
			}

			$.each($("#canvas-txt").children(), function(idx, meta){
				let $this = $(this);
				$this.css('font-size', (parseFloat($this.css('font-size')) * newArea) / previewArea);
			})

			editor.methods.updateComponentColors();

			if(onload_function) {
				let interval = setInterval(function(){
					if(editor.map.loaded() === true) {
						onload_function();
						window.clearInterval(interval);
					}
				}, 2000);
			}
		},

		setCanvasSizeAndBounds: function(width, height, bounds, onload_function) {
			bounds = bounds || [[-122.5456035680492, 37.837101557737185], [-122.5122154302171, 37.79679208988087]];
			editor.methods.setCanvasSize(width, height, function() {
				if(bounds[0] != 0.0 && bounds[1] != 0.0) {
					editor.map.fitBounds(new mapboxgl.LngLatBounds(bounds[0], bounds[1]), {duration: 0, animate: false});
				}
			});

			if(onload_function) {
				let interval = setInterval(function(){
					if(editor.map.loaded() === true) {
						onload_function();
						window.clearInterval(interval);
					}
				}, 2000);
			}
		},

		setCanvasFitScreen: function(){

			if($("#canvas-frame").hasClass('print')) {
				return -1;
			}

			let height 	= (window.innerHeight - 30),
				width 	= (height / 1.5),
				size 	= editor.methods.getMapSizeInPixels();

			// Adjust width based on aspect ratio
			width = height * (size[0] / size[1]);

			$("#canvas-frame").css({'height': height, 'width': width, 'display': 'block'});

			if(editor.map) {
				let bounds = editor.methods.getMapBoundaries();
				editor.map.resize();
				editor.map.fitBounds(new mapboxgl.LngLatBounds(bounds[0], bounds[1]), {duration: 0, animate: false});
			}
		},

		checkout: function() {
			editor.methods.generatePreview(function(){

				// Get bounding box
				let map = editor.map,
					mapCanvas = map.getCanvas(),
					w = mapCanvas.width,
					h = mapCanvas.height,
					cUL = map.unproject([0,0]).toArray(),
					cLR = map.unproject([w,h]).toArray();

				editor.settings.bounds = [cUL, cLR];

				$("#checkout_settings").val(JSON.stringify(editor.settings));
				$("#checkout_form").submit();
			});
		},

		generatePreview: function(onComplete) {

			window.scrollTo(0, 0);

			// Convert the canvas to image and append it
			let canvasElement 	= editor.map.getCanvas(), // Find the canvas generated by MapBox
				img 			= $(`<img style="width:100%; height:auto">`); // Create the image wrapper

			img.attr('src', canvasElement.toDataURL('image/png',1.0));

			// Append the image
			$("#canvas-map").css('display', 'none');

			img.one('load', function() {

				// Convert the HTML to canvas and append it to a PDF file
				html2canvas($("#canvas-frame").get(0), {imageTimeout: 0, allowTaint: true}).then(function(canvas) {

	                $("#checkout_preview").val(canvas.toDataURL('image/png', 1.0));
	                $("#canvas-map").css('display', 'block');
			        img.remove();
			        onComplete();
				});
			}).each(function(){
				if(this.complete) {
					$(this).load();
				}
			});

			$("#canvas-map-wrapper").append(img);
		},

		resetCanvasForm: function() {
			$('#canvas-frame').removeClass('rectangle heart circle noborder');
			$('#canvas-message').show();
		},

		getMapSizeInPixels: function(dpi) {
			dpi = dpi || 300;

			return [(editor.settings.size[0] * 0.0393701) * dpi, (editor.settings.size[1] * 0.0393701) * dpi];
		}
	}
};

require('./components/location');
require('./components/customize');
require('./components/theme');
require('./components/admin');



// Handle Semantic UI Tabs
$(function(){

	$("#canvas-overlay").hide();
	$("#editor-tools .item").click(function(e) {

		let $this 	= $(this),
			tab 	= $this.data('tab');
		
		if($this.hasClass('active')) {
			$("#editor-tools .box").removeClass('active');
			$("#editor-tools .close").removeClass('active');
			$this.removeClass('active');

			$(".mobile-menu-close").removeClass('active');
			$(".mobile-menu-background").removeClass('active');
			return;
		}

		$this.siblings().removeClass("active");
		$this.addClass('active');

		if(tab) {
			$(".tab").removeClass("active");
			$(tab).addClass('active');
		}

		$("#editor-tools .box").addClass('active');
		$("#editor-tools .close").addClass('active');

		$(".mobile-menu-close").addClass('active');
		$(".mobile-menu-background").addClass('active');
	})

	/**
	 ** Mobile Support for Editor Tools Tabs
	 **/

	if(md.mobile() !== null) {
		let wrapper = $("#editor-tools"),
			parent = wrapper.parent();

		wrapper.appendTo("body");
		parent.remove();

		wrapper.find('.headers').removeClass('compact');
		wrapper.find('.headers .active.item').removeClass('active');
		$("#preview-wrapper").addClass('sixteen wide column');
	}

	$(".mobile-menu-background").click(function(){
    	$(".headers .active.item").click();
  	});

	// Handle sticker
	interact('#canvas-sticker').draggable({
	    // enable inertial throwing
	    inertia: true,
	    // keep the element within the area of it's parent
	    restrict: {
	      restriction: "parent",
	      endOnly: true,
	      elementRect: { top: 0, left: 0, bottom: 1, right: 1 }
	    },
	    // enable autoScroll
	    autoScroll: true,

	    // call this function on every dragmove event
	    onmove: dragMoveListener,
  	});

  	function dragMoveListener (event) {
	    var target = event.target,
	        // keep the dragged position in the data-x/data-y attributes
	        x = (parseFloat(target.getAttribute('data-x')) || 0) + event.dx,
	        y = (parseFloat(target.getAttribute('data-y')) || 0) + event.dy;

	    // translate the element
	    target.style.webkitTransform =
	    target.style.transform =
	      'translate(' + x + 'px, ' + y + 'px)';

	    // update the posiion attributes
	    target.setAttribute('data-x', x);
	    target.setAttribute('data-y', y);
	}

	// this is used later in the resizing and gesture demos
	window.dragMoveListener = dragMoveListener;

	// Init All
	let init = require('./components/init');
	init();
})