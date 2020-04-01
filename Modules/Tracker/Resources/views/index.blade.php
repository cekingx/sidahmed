@extends('tracker::layouts.master')

@section('content')
    <div class="main content">
        <div class="ui grid">
            <div class="sixteen wide column">
                <h1 class="ui header">
                    <img src="{{asset('img/tracker/order-box.png')}}"> Howdy!
                </h1>

                <h2 class="ui subtitle header">
                    Not long now to complete your order.
                </h2>

                <div class="ui basic search segment">
                	<p>Start by entering your Etsy Transaction ID e.g. #13138291456, do not confuse with order ID.</p>

                	<form class="ui huge form" id="tracker_form">
                		<div class="ui grid">
                			<div class="sixteen wide mobile five wide computer column">
                				<input type="text" name="order_id" placeholder="Transaction ID" id="tracker_order_id">
                			</div>
                			<div class="sixteen wide mobile four wide computer column">
                				<button type="submit" class="ui primary huge button">START</button>
                			</div>
                		</div>
                	</form>

                    @if(Session::has('error'))
                    <br/>
                    <div class="field">
                        <label>{{Session::get('error')}}</label>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@stop