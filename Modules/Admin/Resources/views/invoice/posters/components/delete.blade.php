@push('component_javascript')
<script>
	function posters_deletePosterSize($id) {
		if(confirm('Are you sure you want to do this action?')) {
			$.ajax({
				url:"{{route('admin::poster-size.destroy', ['id' => 'XX'])}}".replace('XX', $id),
				type:"POST",

				success: function() {
					toastr.success('The poster size was successfully destroyed.');
                	location.reload();
				}
			})
		}
	}
</script>
@endpush