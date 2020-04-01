<div class="ui tiny modal" id="settings_modal">
  	<i class="close icon"></i>
    <div class="header">
        Settings
  	</div>

    <div class="content">
        <div class="field">
            <h4>Append new status message:</h4>
            <div class="ui divider"></div>
            <div class="ui selection dropdown">
                <input type="hidden" id="status_field">
                <i class="dropdown icon"></i>
                <div class="default text">Select a message</div>
                <div class="menu">
                    <div class="item" value="Hold - Waiting response from customer.">
                        Hold - Waiting response from customer.
                    </div>
                    <div class="item" value="Delayed - We are facing technical difficulties with the printer.">
                        Delayed - We are facing technical difficulties with the printer.
                    </div>
                </div>
            </div>

            <div class="ui primary button" id="status_button">
                Append
            </div>
        </div>

        <br/><br/>

        <div class="field">
            <h4>Process Order</h4>
            <div class="ui divider"></div>

            <div class="ui grid">
                <div class="eight wide column">
                    <a class="ui primary button" href="#" onclick="generateFile()">
                        Generate File
                    </a>
                </div>
                <!-- <div class="eight wide column">
                    <a class="ui primary button" onclick='processOrder()' href="#">
                        Digital Delivery
                    </a>
                </div> -->
            </div>
        </div>
    </div>

  	<div class="actions">
        <div class="ui positive right labeled icon button">
            Accept
            <i class="checkmark icon"></i>
	    </div>
    </div>
</div>

@push('javascript')
<script>
    let editingOrder = -1;

    $('.settings.trigger').click(function(){
        let order = $(this).data('order');
        $("#settings_modal").modal('show');
        editingOrder = order;
    });

    // Handle Status Message
    $("#status_button").click(function(){
        let msg = $("#status_field").val();
        if(msg.length) {
            $("#status_button").addClass('loading');

            $.ajax({
                url:"{{route('admin::status.create')}}",
                type:'POST',
                data:{order_id: editingOrder, message: msg},

                success:function(){
                    toastr.success("The status message has been successfully appended to the order's tracking information.");
                    $("#status_button").removeClass('loading');
                    $("#settings_modal").modal('hide');
                }
            })
        }
    })

    function generateFile() {
        $.each(orders, function(idx, meta) {
            if(meta.id == editingOrder) {
                var win = window.open(meta.editor_url, '_blank');
                win.focus();
            }
        })
    }

    function processOrder() {
        let order = editingOrder;
        $.ajax({
            url:"{{route('admin::orders.process')}}",
            type:'POST',
            data:{order_id: order},

            success:function() {
                toastr.success('The order has been successfully processed.');
            }
        })
    }
</script>
@endpush