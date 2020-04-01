@section('options')
<a class="ui primary sort small button" href="javascript:void(0)" data-sort="all">
	ALL (<span class="count"></span>)
</a>

<a class="ui secondary sort_type small button" href="javascript:void(0)" onclick="sortByType(1)">
	DIGITAL (<span class="digital_count"></span>)
</a>

<a class="ui secondary sort_type small button" href="javascript:void(0)" onclick="sortByType(0)">
	PRINT (<span class="print_count"></span>)
</a>

<a class="ui secondary sort small button" href="javascript:void(0)" data-sort="unprocessed">
	UNPROCESSED (<span class="count"></span>)
</a>

<a class="ui secondary sort small button" href="javascript:void(0)" data-sort="processed">
	PROCESSED (<span class="count"></span>)
</a>

<a class="ui secondary sort small button" href="javascript:void(0)" data-sort="printing">
	PRINTING (<span class="count"></span>)
</a>
@endsection

@push('component_javascript')
<script type="text/javascript">
	let currentTab = 'all';
	$(".sort.button").click(function(e) {
		currentTab = $(this).data('sort');

		$(".sort.button").removeClass('primary').addClass('secondary');
		$(this).removeClass('secondary').addClass('primary');

		sortTable();
	})

	$(function(){
		updateTabCount();
	});

	function sortByType(type) {
		currentTab = 'all';
		$(".order").hide();
		$(`.order[data-type=${type}]`).show();	

		$(".sort.button").removeClass('primary').addClass('secondary');
		$(".sort_type.button").removeClass('primary').addClass('secondary');
		$(this).removeClass('secondary').addClass('primary');
	}

	function sortTable() {
		if(currentTab == 'all') {
			$(".order").show();
		}
		else {
			$(".order").hide();
			$(`.order[data-status=${currentTab}]`).show();
		}
		updateTabCount();
	}

	function updateTabCount() {
		$.each($(".sort.button"), function(idx, meta) {
			let status = $(this).data('sort'),
				count  = $(`.order[data-status=${status}]`).size();

			if(status == 'all') {
				$(this).children('.count').text($(".order").size());
			}
			else $(this).children(".count").text(''+count);
		});

		$(".digital_count").text($(".order[data-type=1]").size());
		$(".print_count").text($(".order[data-type=0]").size());
	}
</script>
@endpush