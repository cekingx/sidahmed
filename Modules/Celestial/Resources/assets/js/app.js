const moment = require('moment');

const sizes = require('./components/sizes');

const MobileDetect = require('mobile-detect');
const md = new MobileDetect(window.navigator.userAgent);

const siteUrl = $("meta[name='root-url']").attr("content")


/**
 ** Main Editor Data Structure
 **/

window.editor = {

	settings: {
		title: 'Star Map', // Frame Title

		location: 'San Francisco, CA, USA', // Geo-location name

		customLocation: '', // Custom geo-location text (doesn't change charts)

		date: moment().second(0).minute(0).hour(23), // Datetime format to display chart in a specific time

		customDate: '', // Custom date text. (doesn't change charts)

		message: '', // Custom message to display in the frame

		size: [215.9, 279.4], // Determines the poster size [width, height]

		lat: '37.7749295', // Position

		lng: '-122.4194155', // Position

		design: 'circle', // circle | heart | rectangle

		whitebg: false, // Display a white background (false | true)
		
		borders: true, // Display frame borders (false | true)

		bordersSize: '3px', // Default border size

		bordersPadding: '1.5625rem', // default border padding
		
		grid: false, // Display planet grids (false | true)

		latlng: true, // Display latitude and longitude position (false | true)
		
		constellations: true, // Display constellations lines (false | true)
		
		milkyWay: true, // Display the milky way (false | true)

		digital: false, // Export digital download file or not
		
		colorData: {
			selected: "poster", 
			colors: [
				{type: "poster",	color: "#000000"},
				{type: "map", 		color: "#000000"},
				{type: "text", 		color: "#ffffff"},
				{type: "borders", 	color: "#ffffff"}
			]
		},

		sizes: sizes,

		heartCanvas: [], // Hold the heart image color data in a canvas
	},

	events: {
		onTextChange: function() {

		},

		onComponentColorChange: function() {

		},

		onSettingsChange: function() {

		},

		onDateChange: function() {

		},

		onLocationChange: function() {

		},

		onCustomMessageChange: function() {

		},

		onDesignChange: function() {

		}
	},

	methods: {
		updateMap: function() {
			let config = {},
				color = "#ffffff";

			if(editor.settings.whitebg === true) { 
				let color = '#000000'; 
			} 

			// Handle Constellations
			if(editor.settings.constellations === false) {
				config.constellations = { show:false };
			}
			else {
				config.constellations = {
					show:true, names:false, desig:false,
					linestyle:{ stroke:color, width:1, opacity: 0.5 },
				};
			}

			// Handle map grid
			if(editor.settings.grid === false){
				config.lines = { 
					graticule:{ show:false },
					equatorial:{ show:false },
					ecliptic:{ show:false },
					galactic:{ show:false },
					supergalactic:{ show:false }
				};
			}
			else {
				config.lines = { 
					graticule:{ show:true, stroke:color, width:2, opacity:0.25,
					lon:{ pos:[""], fill:color, font:"10px Helvetica, Arial, sans-serif" },
					lat:{ pos:[""], fill:color, font:"10px Helvetica, Arial, sans-serif" }},
					equatorial:{ show:true, stroke:color, width:0.5, opacity: 0.25 },
					ecliptic:{ show:false },
					galactic:{ show:false },
					supergalactic:{ show:false }
				};
			}

			// Handle Milky Way

			if(editor.settings.milkyWay === false){
				config.mw = { show:false };
			}
			else {
				config.mw = { show:true, style:{ fill:color, opacity:0.15 } };
			}

			Celestial.apply(config);
		},

		updateBorders: function() {
			let elm = $("#canvas-border");
			if(editor.settings.borders === false) {
				elm.addClass('noborder');
			}
			else {
				elm.removeClass('noborder');

				elm.css('border-width', editor.settings.bordersSize);
				$("#canvas-wrapper").css('padding', editor.settings.bordersPadding);
			}
		},

		updateComponentColors: function() {
 
			// Map array for easier manipulation
			let colors = [], frame = '';
			$.each(editor.settings.colorData.colors, function(index, meta) {
				colors[meta.type] = meta.color;
			});

			// Handle White Background
			if(editor.settings.whitebg === true){
				$('#canvas-frame').addClass('whitebg');
				Celestial.apply({background: {stroke:"#000000"}});
				changeHeartColor("#ffffff");
			}
			else {
				$('#canvas-frame').removeClass('whitebg');

				$('#canvas-border').css('border-color', ''+colors.borders+'');
				$('#canvas-map-wrapper').css('border-color', ''+colors.borders+'');

				// Change text color
				$('#canvas-txt').children().css('color', ''+colors.text+'');
				$('#canvas-message').css('color', ''+colors.text+'');

				// Change frame color
				$("#canvas-wrapper").css("background-color",''+colors.poster+'');
				$("#canvas-map-wrapper").css("background-color",''+colors.poster+'');
				$("#canvas-txt").css("background-color",''+colors.poster+'');
				changeHeartColor(''+colors.poster+'');

				// Change celestial colors & borders
				Celestial.apply({background: {fill: colors.map, stroke:colors.borders}});
			}

			editor.events.onComponentColorChange();
		},

		updateText: function(){
			if(editor.settings.customLocation.length > 0) {
				$("#canvas-location").text(editor.settings.customLocation);
			}
			else $("#canvas-location").text(editor.settings.location);

			if(editor.settings.customDate.length > 0) {
				$("#canvas-date").text(editor.settings.customDate);
			}
			else $("#canvas-date").text(editor.settings.date.format("MM/DD/YYYY"));

			if(editor.settings.latlng === false) {
				$("#canvas-latlong").hide();
			}
			else $("#canvas-latlong").show();

			$("#canvas-title").text(editor.settings.title);
			$('#canvas-message').html(editor.settings.message.replace(/\r?\n/g,'<br/>'));
			editor.events.onTextChange();
		},

		updateDate: function(){
			let date = editor.settings.date;
			Celestial.date(date.toDate());

			$('#day-left').click(); // Workaround fix for animation
			$('#day-right').click();

			editor.methods.updateText();
			editor.events.onDateChange();
		},

		updateLocation: function(){
			$.ajax({
				type: "GET",
				dataType: "json",
				url: "https://maps.googleapis.com/maps/api/geocode/json",
				data: {'address': editor.settings.location, 'sensor':false, 'key':'AIzaSyDcMmi7sQFB1D5-U-sBptyBkRhZr-WMSJw'},

				success: function(data){
					if(!editor.settings.customLocation.length) {
						$('#canvas-location').html(data.results[0].formatted_address);
					}
					
					var latd = '';
					var lat = data.results[0].geometry.location.lat;
					if(lat<0){ latd='S'; }else{ latd='N'; }
					
					var lngd = '';
					var lng = data.results[0].geometry.location.lng;
					if(lng<0){ lngd='W'; }else{ lngd='E'; }
					
					$('#canvas-latlong').html(Math.abs(lat.toFixed(2))+'&deg;'+latd+'&nbsp;|&nbsp;'+Math.abs(lng.toFixed(2))+'&deg;'+lngd);
					$('#lat').val(lat);
					$('#lon').val(lng);

					editor.settings.lat = lat;
					editor.settings.lng = lng;
					
					var field = document.getElementById('lon');
					if(field.fireEvent) {
						field.fireEvent('onchange');
					}
					else if(field.dispatchEvent){
						var event = document.createEvent('HTMLEvents');
						event.initEvent('change', false, false);
						field.dispatchEvent(event);
					}

					editor.events.onLocationChange();
				}
			});
		},

		updateMapDesign: function() {
			// Loading screen
			$('#canvas-map').hide();
			$('#canvas-overlay').show();

			// Reset the canvas form before applying the new one
			editor.methods.resetCanvasForm();

			$("#location_message").prop('disabled', false);

			if(editor.settings.design == 'circle') {
				$('#canvas-frame').addClass('circle');
			}
			else if(editor.settings.design == 'heart') {
				$('#canvas-frame').addClass('heart');
				$('#heartImage').show();
			}
			else if(editor.settings.design == 'rectangle') {
				$('#canvas-frame').addClass('rectangle');
				$('#canvas-message').hide();

				$("#location_message").prop('disabled', true);
			}

			// Disable Loading Screen
			setTimeout(function(){
				$('#canvas-overlay').hide();
				$('#canvas-map').show();
				Celestial.resize(0);
			}, 3000);
		},

		resetCanvasSize: function() {
			$("#canvas-wrapper").attr('style', '');
			$("#canvas-txt").attr('style', '');
			$("#canvas-map-wrapper").attr('style', '');
			$("#canvas-border").attr('style', '');
			Celestial.resize(0);

			Celestial.apply({
				stars: { size:6 },
				constellations:{
					linestyle: { width: 1 },
				},
				lines:{ 
					graticule: { width: 0.8 },
					equatorial: { width: 0.5 },
				},
				background: { width: 3 }
			});
		},

		setCanvasSize: function(width, height) {
			if((width * height) < 120000) {
				width  = width  * 2.0;
				height = height * 2.0;
			}
			else {
				width  = width  * 1.5;
				height = height * 1.5;
			}

			$("#canvas-wrapper").css('width', width + 'mm').css('height', height + 'mm');
			$("#canvas-txt").css('font-size', width / 10.0);
			$("#canvas-message").css('font-size', width / 10.0);
			Celestial.resize(0);

			let area = (parseFloat(width) * parseFloat(height)),
				newSizes = {
					stars: {
					 	size: 6 + ((area*2) / 60322.46),
					},
					constellations:{
						linestyle:{ width: 1 },
					},
					lines:{ 
						graticule:{ width: 0.8 + ((area*2) / 60322.46) },
						equatorial:{ width: 0.5 + ((area*2) / 60322.46) },
					},
					background: { width: 3 + ((area*2) / 60322.46) }
				};

			$("#canvas-border").css('border-width', parseInt(editor.settings.bordersSize) + ((area*2) / 60322.46));
			Celestial.apply(newSizes);
		},

		exportImage: function() {
			editor.methods.setCanvasSize(editor.settings.size[0], editor.settings.size[1]);
			Celestial.apply({background: {fill: 'transparent'}});
			window.scrollTo(0, 0);

			$("#canvas-frame").addClass('print'); // Print Ready

			let _canvasWrapper = $("#canvas-map");
			let _canvas = _canvasWrapper.find("canvas");
			let _image = _canvas[0].toDataURL('image/png',1.0);

			_canvas.hide();

			let img = $('<img src="'+_image+'">');

			_canvasWrapper.find("#celestial-map").append(img);

			html2canvas(_canvasWrapper.get(0), {imageTimeout: 0}).then(function(canvas) {

                let imgData = canvas.toDataURL('image/png'),
                	win = window.open("", "Stars Chart");

		        win.document.body.innerHTML = '<img src="'+imgData+'"/>';
		        win.focus();

		        _canvas.show();
		        img.remove();
		        editor.methods.resetCanvasSize();
		        $("#canvas-frame").removeClass('print'); // Print Ready
			});
		},

		exportPDF: function(onComplete) {

			$("#preview-wrapper").css('opacity', 0);

			editor.methods.setCanvasSize(editor.settings.size[0], editor.settings.size[1]);
			window.scrollTo(0, 0);

			$("#canvas-frame").addClass('print'); // Print Ready

			let _canvasWrapper = $("#canvas-wrapper");
			let _canvas = _canvasWrapper.find("canvas");
			let _image = _canvas[0].toDataURL('image/png',1.0);

			_canvas.hide();

			let img = $('<img src="'+_image+'">');

			_canvasWrapper.find("#celestial-map").append(img);

			html2canvas(_canvasWrapper.get(0), {imageTimeout: 0}).then(function(canvas) {

                var imgData = canvas.toDataURL('image/png');
                var doc = new jsPDF("p", "mm", editor.settings.size);
                doc.deletePage(1);
                doc.addPage(editor.settings.size[0], editor.settings.size[1]);
                doc.addImage(imgData, 'PNG', 0, 0, editor.settings.size[0], editor.settings.size[1]);
                doc.save('sample.pdf');

		        _canvas.show();
		        img.remove();
		        editor.methods.resetCanvasSize();
		        $("#canvas-frame").removeClass('print'); // Print Ready

		        onComplete();
			});
		},

		resetCanvasForm: function() {
			$('#canvas-frame').removeClass('rectangle heart circle noborder');
			$('#heartImage').hide();
			$('#canvas-message').show();
		}
	}
};

require('./components/location');
require('./components/customize');
require('./components/theme');
require('./components/finish');


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

	// Init All
	let init = require('./components/init');
	init();
})

/**
 ** Initialize heart image
 **/
let canvas = document.createElement("canvas"),
	ctx = canvas.getContext("2d"),
	originalPixels = null,
	currentPixels = null;

let $img = $('<img src="'+ siteUrl +'img/editor/heart.png" class="heart" id="heartImage"/>').on('load', function(){
	let img = this;
	canvas.width = img.width;
    canvas.height = img.height;

    ctx.drawImage(img, 0, 0, img.naturalWidth, img.naturalHeight, 0, 0, img.width, img.height);
    originalPixels = ctx.getImageData(0, 0, img.width, img.height);
    currentPixels = ctx.getImageData(0, 0, img.width, img.height);
});

$("#celestial-map").append($img);

function hexToRGB(hex)
{
    let long = parseInt(hex.replace(/^#/, ""), 16);
    return {
        R: (long >>> 16) & 0xff,
        G: (long >>> 8) & 0xff,
        B: long & 0xff
    };
}

window.changeHeartColor = function(hex) {
    let newColor = hexToRGB(hex);

    for(let I = 0, L = originalPixels.data.length; I < L; I += 4)
    {
        if(currentPixels.data[I + 3] >= 0) // If it's not a transparent pixel
        {
            currentPixels.data[I] = newColor.R;
            currentPixels.data[I + 1] = newColor.G;
            currentPixels.data[I + 2] = newColor.B;
        }
    }

    ctx.putImageData(currentPixels, 0, 0);
    $("#heartImage").attr('src', canvas.toDataURL("image/png"));
}