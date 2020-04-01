<div class="ui tiny modal" id="methods_edit_modal">
  	<i class="close icon"></i>
    <div class="header">
        Edit Shipping Method
  	</div>

    <div class="content">
        <form class="ui form" method="POST" id="methods_edit_form">
            @csrf

            <div class="field">
                <label>Name</label>
                <div class="ui input">
                    <input type="text" name="name" id="methods_edit_field_name" required>
                </div>
            </div>

            <div class="field">
                <label>Cost (£)</label>
                <div class="ui input">
                    <input type="number" name="cost" placeholder="Introduce the cost" id="methods_edit_field_cost">
                </div>
            </div>
        </form>
    </div> 

  	<div class="actions">
        <div class="ui positive right labeled icon button" onclick="$('#methods_edit_form').submit();">
            Accept
            <i class="checkmark icon"></i>
	    </div>
    </div>
</div>

@push('component_javascript')
<script type="text/javascript">

    // Handle Events
    $(".method.edit.trigger").click(function(){
        setCurrentShippingMethod($(this).data('method'));
        methods_edit();
    });

    $("#methods_edit_form").submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url:"{{route('admin::shipping-method.update', ['id' => 'XX'])}}".replace('XX', getCurrentShippingMethod().id),
            type:"POST",
            data:formData,

            success:function() {
                toastr.success('The shipping method was successfully edited');
                location.reload();
            }
        })
    })


    /**
     ** Core Functions
     **/

    function methods_edit() {
        methods_edit_prepareModal();
        methods_edit_showModal();
    }

    function methods_edit_prepareModal(shippingMethod) {
        shippingMethod = shippingMethod || getCurrentShippingMethod();

        let fields = [
            {element: $("#methods_edit_field_name"),     value: shippingMethod.name},
            {element: $("#methods_edit_field_cost"),     value: shippingMethod.cost}
        ];

        // Display values
        populateElements(fields);
    }

    function methods_edit_showModal() {
        $("#methods_edit_modal").modal('show');
    }
</script>
@endpush