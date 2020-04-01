let init = function() { 
	
	/**
	 ** Init d3-celestial
	 **/

	var config = { 
		projection: "airy", 
		geopos:[editor.settings.lat, editor.settings.lng],
		interactive:false,
		form: true,
		location: true,
		datapath: "d3-celestial/data/",
		stars:{ 
			colors:false, 
			names:false,
		 	size:6,
		},
		dsos:{ show:false },
		planets:{ show:false },
		constellations:{
		 	show:true, 
		 	names:false, 
		 	desig:false,
			linestyle:{ 
				stroke:"#ffffff", 
				width:1, 
				opacity: 0.5 
			},
		},
		mw:{ 
			show:true, 
			style:{ 
				fill:"#ffffff", 
				opacity:0.125 
			} 
		},
		lines:{ 
			graticule:{ 
				show:false, stroke:"#fff", width:0.8, opacity:0.25,
				lon:{ pos:[""], fill:"#eee", font:"10px Helvetica, Arial, sans-serif" },
				lat:{ pos:[""], fill:"#eee", font:"10px Helvetica, Arial, sans-serif" }
			},
			equatorial:{ 
				show:false, stroke:"#eee", width:0.5, opacity: 0.25 
			},
			ecliptic:{ 
				show:false 
			},
			galactic:{ 
				show:false 
			},
			supergalactic:{ 
				show:false 
			}
		},
		background: { 
			fill:"#000", 
			stroke:"#fff", 
			width:3  
		}
	}
	
	Celestial.display(config);

	editor.methods.updateText();
	editor.methods.updateMap();
	editor.methods.updateMapDesign();


	/**
	 ** Initialize the data visually
	 **/

	$("#location_location").val(editor.settings.location);
	$("#location_date").val(editor.settings.date.format("MM/DD/YYYY"));
	$("#location_message").val(editor.settings.message);

	$("#customize_"+editor.settings.design+"Map").prop('checked', true);
	$("#customize_whiteBackground").prop('checked', editor.settings.whitebg);
	$("#customize_borders").prop('checked', editor.settings.borders);
	$("#customize_mapGrid").prop('checked', editor.settings.grid);
	$("#customize_constellations").prop('checked', editor.settings.constellations);
	$("#customize_milkyWay").prop('checked', editor.settings.milkyWay);


	$("#finish_title").val(editor.settings.title);
	$("#finish_customLocationText").val(editor.settings.customLocation);
	$("#finish_customDateText").val(editor.settings.customDate);
	$("#finish_latlng").prop('checked', editor.settings.latlng);
	$("#finish_digitalCopy").prop('checked', editor.settings.digital);
};

module.exports = init;
