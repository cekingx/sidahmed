@push('component_javascript')
<script>
	function methods_deleteShippingMethod($id) {
		if(confirm('Are you sure you want to do this action?')) {
			$.ajax({
				url:"{{route('admin::shipping-method.destroy', ['id' => 'XX'])}}".replace('XX', $id),
				type:"POST",

				success: function() {
					toastr.success('The shipping method was successfully destroyed.');
                	location.reload();
				}
			})
		}
	}
</script>
@endpush