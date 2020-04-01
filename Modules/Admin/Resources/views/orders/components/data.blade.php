<div class="ui tiny modal" id="data_modal">
  	<i class="close icon"></i>
    <div class="header">
        Order Product Data
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
    function data_showModal(order_id) {

        let order = setCurrentOrder(order_id);
        if(order === null) return false;

        let items = '';
        $.each(order.data, function(idx, optionField) {
            if(Object.prototype.toString.call(optionField) === '[object Array]' || Object.prototype.toString.call(optionField) === '[object Object]') {
                items += `<li><strong>${idx}:</strong></li>`;
                items += '<ul>';
                $.each(optionField, function(innerIndex, innerField) {
                    items += `<li>${innerField}</li>`;
                })
                items += '</ul>';
            }
            else items += `<li><strong>${idx}:</strong> ${optionField}</li>`;
        })

        $("#data_modal .content").html(`
            <h4>Below you will see the product dataset.</h4>

            <ul>
                ${items}
            </ul>
        `);

        $("#data_modal").modal('show');
    }
</script>
@endpush