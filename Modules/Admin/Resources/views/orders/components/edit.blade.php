<div class="ui tiny modal" id="edit_modal">
  	<i class="close icon"></i>
    <div class="header">
        Edit Order
  	</div>

    <div class="content">
        <form class="ui form" method="POST" id="edit_form">
            @csrf

            <div class="field">
                <label>
                    Poster Type
                </label>

                <select class="ui selection dropdown" name="type" id="edit_field_type">
                    <option value="cities">City</option>
                    <option value="celestial">Star</option>
                    <option value="moon">Moon</option>
                </select>
            </div>

            <div class="field">
                <label>
                    Delivery Type
                </label>

                <select class="ui selection dropdown" name="delivery" id="edit_field_delivery">
                    <option value="1">Digital</option>
                    <option value="0">Print</option>
                </select>
            </div>

            <div class="field">
                <label>
                    Poster Size (UNIT: mm)
                </label>

                <div class="fields">
                    <div class="field">
                        <div class="ui input">
                            <input type="number" name="size_width" id="edit_field_width">
                        </div>
                    </div>

                    <div class="field">
                        <div class="ui input">
                            <input type="number" name="size_height" id="edit_field_height">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div> 

  	<div class="actions">
        <div class="ui positive right labeled icon button" onclick="$('#edit_form').submit();">
            Accept
            <i class="checkmark icon"></i>
	    </div>
    </div>
</div>

@push('component_javascript')
<script type="text/javascript">

    // Handle Events
    $(".edit.trigger").click(function(){
        setCurrentOrder($(this).data('order'));
        edit();
    });

    $("#edit_form").submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url:"{{route('admin::orders.edit', ['order' => 'XX'])}}".replace('XX', getCurrentOrder().id),
            type:"POST",
            data:formData,

            success:function() {
                toastr.success('The order was successfully edited');
                location.reload();
            }
        })
    })


    /**
     ** Core Functions
     **/

    function edit() {
        edit_prepareModal();
        edit_showModal();
    }

    function edit_prepareModal(order) {
        order = order || getCurrentOrder();

        // Assign a value to each element
        if(order.data === undefined || order.data === null) {
            order.data = {
                size: [0.0, 0.0]
            }
        }

        let fields = [
            {element: $("#edit_field_type"),     value: order.type},
            {element: $("#edit_field_delivery"), value: (order.digital == 1) ? 'Digital' : 'Print'},
            {element: $("#edit_field_width"),    value: order.data.size[0] || 0},
            {element: $("#edit_field_height"),   value: order.data.size[1] || 0},
        ];

        // Display values
        populateElements(fields);
    }

    function edit_showModal() {
        $("#edit_modal").modal('show');
    }
</script>
@endpush