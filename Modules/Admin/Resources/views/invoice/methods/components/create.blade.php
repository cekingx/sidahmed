<div class="ui tiny modal" id="methods_create_modal">
  	<i class="close icon"></i>
    <div class="header">
        Create Shipping Method
  	</div>

    <div class="content">
        <form class="ui form" method="POST" id="methods_create_form" action="{{route('admin::shipping-method.store')}}">
            @csrf

			<div class="field">
				<label>Name</label>
				<div class="ui input">
					<input type="text" name="name" required>
				</div>
			</div>

			<div class="field">
				<label>Cost (£)</label>
				<div class="ui input">
					<input type="number" name="cost" placeholder="Introduce the cost">
				</div>
			</div>
        </form>
    </div> 

  	<div class="actions">
        <div class="ui positive right labeled icon button" onclick="$('#methods_create_form').submit();">
            Accept
            <i class="checkmark icon"></i>
	    </div>
    </div>
</div>

@push('component_javascript')
<script>
	function methods_create_showModal() {
		$("#methods_create_modal").modal('show');
	}
</script>
@endpush