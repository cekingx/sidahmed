@extends('admin::layouts.master')

@section('title', 'Invoice Table')

@section('content')
@include('admin::invoice.methods.index')
<div class="ui divider"></div>
@include('admin::invoice.posters.index')
@endsection

@push('javascript')
<script>
	$(function(){
		$(".ui.dropdown").dropdown();
	})

	// Utils

	window.populateElements = function(fields) {
        $.each(fields, function(index, field) {
            if(field.element.parent().hasClass('dropdown')) {
                field.element.dropdown("set selected", field.value);
            }
            if(field.element.is(':checkbox')) {
            	field.element.prop('checked', field.value);
            }
            else {
                field.element.val(field.value);
            }
        });   
    }
</script>
@endpush