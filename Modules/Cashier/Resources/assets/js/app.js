
function cart_updateInterface() {
	$total = 0.00;
	$.each(Cart, function(idx, meta) {
		$total += meta.price * meta.quantity;
	});

	$("#cart_total").text($total);
}


function cart_adjustItemQuantity(itemId, quantity) {
	$.each(Cart, function(idx, meta) {
		if(meta.id === itemId) {
			meta.quantity = quantity;
		}
	})

	$.ajax({
		url: siteUrl + `cart/edit`,
		method: "POST",
		data: {item: itemId, quantity: quantity}
	})

	cart_updateInterface();
}


$(".quantity").change(function(e){
	cart_adjustItemQuantity($(this).data('item'), parseInt($(this).val()));
});