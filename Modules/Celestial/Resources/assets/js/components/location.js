const moment = require('moment');

/**
 ** Handle Location Section
 **/

function location_setLocation(location) {
	editor.settings.location = location;
	editor.methods.updateLocation();
}

function location_setDate(datetime) {
	editor.settings.date = datetime;
	editor.methods.updateDate();
}

function location_setMessage(msg) {
	editor.settings.message = msg;
	editor.methods.updateText();
}

$(function(){

	$('[data-toggle="datepicker"]').datepicker().on('pick.datepicker', function(e){
		let date = moment(e.date);
		location_setDate(date);
		$("#location_date").val(date);
	});

	$("#location_location").change(function(){
		location_setLocation($(this).val());
	})

	$("#location_message").keyup(function(){
		location_setMessage($(this).val());
	})
})