let init = function() { 
	
	// Fix checkout button

	if(md.mobile() == null) {
		$(".editor .checkout.button").css('width', document.getElementById('tools-wrapper').offsetWidth).css('display', 'block');

		$(window).resize(function(){
			$(".editor .checkout.button").css('width', document.getElementById('tools-wrapper').offsetWidth);
		})
	}
	else {
		$(".editor .checkout.button").addClass('full-width');
	}

	// Handle Canvas Size
	if(!$("body").hasClass('print')) {
		if(md.mobile() == null) {
			editor.methods.setCanvasFitScreen();
			$(window).resize(function(){
				if(!$("body").hasClass('print')) {
					editor.methods.setCanvasFitScreen();
				}
			})
		}
	}

	// Render map
    var style = editor.settings.design;
    if (style.indexOf('tilehosting') >= 0)
            style += '?key=' + mapTilerAccessToken;

    editor.map = new mapboxgl.Map({
        container: 'canvas-map',
        center: [editor.settings.lng, editor.settings.lat],
        zoom: editor.settings.zoom,
        pitch: 0,
        style: style,
        preserveDrawingBuffer: true
    });

    editor.map.addControl(new mapboxgl.NavigationControl({
        position: 'top-left'
    }));

    $(".mapboxgl-ctrl-logo").css('display', 'none');

    if($("body").hasClass('print')) {
		editor.methods.setCanvasSizeAndBounds(editor.settings.size[0], editor.settings.size[1], editor.settings.bounds);
	}
	else {
	    if(editor.settings.bounds != null) {
	    	editor.map.fitBounds(new mapboxgl.LngLatBounds(editor.settings.bounds[0], editor.settings.bounds[1]), {duration: 0, animate: false});
	    }
	}

    /*if(md.mobile() !== null) {
    	editor.map.fitBounds(new mapboxgl.LngLatBounds([-122.50835304922082, 37.80136996615036], [-122.39299660390861, 37.65609630134476]), {duration: 0, animate: false});
    }*/


    //editor.map.on('moveend', updateLocationInputs).on('zoomend', updateLocationInputs);
    //updateLocationInputs();

	editor.methods.updateAll();
	editor.methods.updateEditorFields();
	//editor.methods.setCanvasSize(editor.settings.size[0], editor.settings.size[1]);

	setTimeout(function(){
		$(".mapboxgl-ctrl-bottom-right").appendTo('body').css('position', 'fixed');
	}, 1500);
};

module.exports = init;
