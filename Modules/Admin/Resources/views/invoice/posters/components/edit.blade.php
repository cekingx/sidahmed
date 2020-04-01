<div class="ui tiny modal" id="posters_edit_modal">
  	<i class="close icon"></i>
    <div class="header">
        Edit Poster Size
  	</div>

    <div class="content">
        <form class="ui form" method="POST" id="posters_edit_form">
            @csrf

            <div class="field">
                <label>Name (optional)</label>
                <div class="ui input">
                    <input type="text" name="name" id="posters_edit_field_name">
                </div>
            </div>

            <div class="field">
                <label>Unit</label>
                <select class="ui selection dropdown" name="unit" id="posters_edit_field_unit">
                    <option value="mm">Millimeters (mm)</option>
                    <option value="cm">Centimeters (cm)</option>
                    <option value="in">Inches (in)</option>
                </select>
            </div>

            <div class="field">
                <label>Width</label>
                <div class="ui input">
                    <input type="number" name="width" placeholder="Introduce the width" id="posters_edit_field_width">
                </div>
            </div>

            <div class="field">
                <label>Height</label>
                <div class="ui input">
                    <input type="number" name="height" placeholder="Introduce the height" id="posters_edit_field_height">
                </div>
            </div>

            <div class="field">
                <label>Cost (£)</label>
                <div class="ui input">
                    <input type="number" name="cost" placeholder="Introduce the cost" id="posters_edit_field_cost">
                </div>
            </div>
        </form>
    </div> 

  	<div class="actions">
        <div class="ui positive right labeled icon button" onclick="$('#posters_edit_form').submit();">
            Accept
            <i class="checkmark icon"></i>
	    </div>
    </div>
</div>

@push('component_javascript')
<script type="text/javascript">

    // Handle Events
    $(".poster.edit.trigger").click(function(){
        setCurrentPosterSize($(this).data('postersize'));
        posters_edit();
    });

    $("#posters_edit_form").submit(function(e) {
        e.preventDefault();
        let formData = $(this).serialize();

        $.ajax({
            url:"{{route('admin::poster-size.update', ['id' => 'XX'])}}".replace('XX', getCurrentPosterSize().id),
            type:"POST",
            data:formData,

            success:function() {
                toastr.success('The poster size was successfully edited');
                location.reload();
            }
        })
    })


    /**
     ** Core Functions
     **/

    function posters_edit() {
        posters_edit_prepareModal();
        posters_edit_showModal();
    }

    function posters_edit_prepareModal(posterSize) {
        posterSize = posterSize || getCurrentPosterSize();

        let fields = [
            {element: $("#posters_edit_field_name"),     value: posterSize.name},
            {element: $("#posters_edit_field_unit"),     value: posterSize.unit},
            {element: $("#posters_edit_field_width"),    value: posterSize.width},
            {element: $("#posters_edit_field_height"),   value: posterSize.height},
            {element: $("#posters_edit_field_cost"),     value: posterSize.cost}
        ];

        // Display values
        populateElements(fields);
    }

    function posters_edit_showModal() {
        $("#posters_edit_modal").modal('show');
    }
</script>
@endpush