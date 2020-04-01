@extends('tracker::layouts.master')

@section('content')
    <div class="placeholders content">
        @if(!$orders->count())
        <h1 class="ui nowrap header">
            <img src="{{asset('img/tracker/order-box.png')}}"> Order
        </h1>

        <h2 class="ui subtitle header">
            We could not find this order in our system.
        </h2>
        @else
        
        <div class="ui equal width grid">
            @foreach($orders as $order)
            <div class="column">
                <div class="placeholder">
                    @if(!empty($order->file))
                    <img src="{{$order->file}}">
                    @else
                    <img src="{{asset('/img/placeholders/'.$order->type.'.jpg')}}">
                    @endif

                    @if($order->etsy_verified)
                    <a class="ui primary button" href="{{$order->tracker_url}}">
                        Tracking
                    </a>
                    @else
                    <a class="ui primary button" href="{{$order->url.'?etsy='.$order->etsy_transaction}}">
                        Edit Poster
                    </a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        @endif
    </div>
@stop
