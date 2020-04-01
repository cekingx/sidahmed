@extends('admin::layouts.master')

@section('title', 'Control Panel')

@section('content')
<div class="ui text container">
	<div class="ui grid">
		<div class="eight wide column">
			<div class="ui center aligned infocard teal inverted segment">
				<div class="count">
					{{$orders->week}}
				</div>
				<div class="label">
					orders
				</div>
			</div>
		</div>
	</div>

	<div class="mt-5"></div>

	@if($orders->pending > 0)
	<div class="ui grid">
		<div class="sixteen wide column">
			<div class="ui icon warning message">
			  	<i class="bullhorn icon"></i>
			  	<div class="content">
			    	<div class="header">
				      	Hey! Watch out.
				    </div>
			    	<p>
						There are <strong>{{$orders->pending}}</strong> pending orders, waiting to be processed.
			    	</p>
			  	</div>
			</div>
		</div>

		<div class="sixteen wide column">
			<a class="ui yellow huge fluid button" href="{{route('admin::orders')}}">
				Process Orders
			</a>
		</div>
	</div>
	@endif
</div>
@stop
