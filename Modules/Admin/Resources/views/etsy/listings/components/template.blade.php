<div class="ui tiny modal" id="settings_modal">
	<i class="close icon"></i>
	<div class="header">
		Attach Template
	</div>
	<div class="content">
		<div class="field">
            <h4>Attach template to this listing:</h4>
            <div class="ui selection dropdown">
                <input type="hidden" id="settings_template">
                <i class="dropdown icon"></i>
                <div class="default text">Select a template</div>
                <div class="menu">
                	@foreach($templates as $template)
                    <div class="item" value="{{$template->id}}" data-name="{{$template->name}} (#{{$template->id}})" data-id="{{$template->id}}">
                        {{$template->name}} (#{{$template->id}})
                    </div>
                    @endforeach
                </div>
            </div>
		</div>
	</div>
	<div class="actions">
		<div class="ui black deny button">
			Nope
		</div>
		<div class="ui positive right labeled icon button" id="settings_modal_accept">
			Choose
			<i class="checkmark icon"></i>
		</div>
	</div>
</div>

@push('javascript')
<script>
	let editingListing  = -1,
        lastName        = '',
        lastID          = -1;

    $("#settings_modal").on('click', '.item', function(e) {
        lastName = $(this).data('name');
        lastID = $(this).data('id');
    });

    $('.settings.trigger').click(function(){
        let listing = $(this).data('listing');
        $("#settings_modal").modal('show');
        editingListing = listing;
    });

    // Handle Status Message
    $("#settings_modal_accept").click(function() {
        let template_id = $("#settings_template").val();
        if(template_id) {
            $("#settings_modal").modal('hide');

            // Update table
            $("#listing_template_text_"+editingListing).html(lastName);

            $.ajax({
                url:"{{route('admin::templates.listing')}}",
                type:'POST',
                data:{listing_id: editingListing, template_id: lastID}
            })
        }
    })
</script>
@endpush