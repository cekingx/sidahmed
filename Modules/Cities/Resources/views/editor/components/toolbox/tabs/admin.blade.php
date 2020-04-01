@if(Auth::check() && Auth::user()->isAdmin() && ($mode != 'etsy'))

@if(!isset($order))
<a class="ui admin fluid primary button template_name pointer" href="#" onclick="showTemplateModal()">
	New Template
</a>

<div class="ui tiny modal" id="template_modal">
	<i class="close icon"></i>
	<div class="header template_name">
		New Template
	</div>

	<div class="content">
		<form class="ui form" id="template_form">
			<input type="hidden" id="template_form_id" name="template_id">
			<input type="hidden" id="template_form_settings" name="settings">
			<input type="hidden" id="template_form_type" name="type" value="cities">
			<input type="hidden" id="template_form_preview" name="preview">

			<div class="field">
				<label>Template Name</label>
				<div class="ui fluid input">
					<input type="text" id="template_form_name" name="name">
				</div>
			</div>
		</form>
	</div>
	<div class="actions">
		<div class="ui warning button" style="display:none" id="template_create_new">
			Create New
		</div>

		<div class="ui black deny button">
			Cancel
		</div>

		<a class="ui positive right labeled icon button" onclick="$('#template_form').submit()">
			Save
			<i class="checkmark icon"></i>
		</a>
	</div>
</div>
@endif

<script>
	window.authenticated = true;
</script>
@endif