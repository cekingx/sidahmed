$(function(){
	$("#tracker_form").submit(function(e) {
		e.preventDefault();

		let order = $("#tracker_order_id").val();
		if(order) {
			window.location.replace(siteUrl + 'tracker/' + order);
		}
	})
})