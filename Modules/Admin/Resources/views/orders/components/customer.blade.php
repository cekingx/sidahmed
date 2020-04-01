<div class="ui tiny modal" id="customer_modal">
  	<i class="close icon"></i>
    <div class="header">
        Customer & Shipping
  	</div>

    <div class="content">
    </div>

  	<div class="actions">
        <div class="ui positive right labeled icon button">
            Accept
            <i class="checkmark icon"></i>
	    </div>
    </div>
</div>

@push('javascript')
<script type="text/javascript">
    function customer_showModal(order_id) {

        let order = setCurrentOrder(order_id);
        if(order === null) return false;

        let items = '';
        $.each(order.customer, function(idx2, customerField) {
            if(Object.prototype.toString.call(customerField) === '[object Array]' || Object.prototype.toString.call(customerField) === '[object Object]') {
                $.each(customerField, function(idx3, shippingField) {
                    items += `<li>${shippingField}</li>`;
                })
            }
            else items += `<li>${customerField}</li>`;
        })

        $("#customer_modal .content").html(`
            <h4>Below you will see the customer dataset.</h4>

            <ul>
                ${items}
            </ul>
        `);

        $("#customer_modal").modal('show');
    }
</script>
@endpush