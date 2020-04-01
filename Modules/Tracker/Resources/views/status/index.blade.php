@extends('tracker::layouts.master')

@section('content')
    <div class="main content">
        <div class="ui grid">
            <div class="sixteen wide column">
                <h1 class="ui nowrap header">
                    <img src="{{asset('img/tracker/order-box.png')}}"> Order Status
                </h1>

                @if(!$order)
                <h2 class="ui subtitle header">
                    We could not find this order in our system.
                </h2>
                @else
                <h2 class="ui subtitle header">
                    @if($order->download && $order->digital)
                    <div class="ui grid">
                        <div class="twelve wide column">
                            Your poster is ready for download.
                        </div>
                        <div class="four wide column">
                            <a href="{{$order->getDownloadLink()}}" class="ui primary button">
                                Download
                            </a>
                        </div>
                    </div>
                    @else
                        @if($order->messages->last())
                            {{$order->messages->last()->message}}
                        @else
                        We have received your order!
                        @endif
                    @endif
                </h2>

                <div class="ui flow segment">
                    <div class="ui equal width grid">
                        <div class="column">
                            <div class="status {{$checks[0]}}">
                                <i class="check circle icon"></i> Received
                            </div>
                        </div>
                        <div class="sep column">
                            <span class="separator"></span>
                        </div>
                        <div class="column">
                            <div class="status {{$checks[1]}}">
                                <i class="check circle icon"></i> Processing
                            </div>
                        </div>
                        <div class="sep column">
                            <span class="separator"></span>
                        </div>
                        @if($order->digital)
                        <div class="column">
                            <div class="status {{$checks[3]}}">
                                <i class="check circle icon"></i> File Created
                            </div>
                        </div>
                        @else
                        <div class="column">
                            <div class="status {{$checks[2]}}">
                                <i class="check circle icon"></i> Printing
                            </div>
                        </div>
                        <div class="sep column">
                            <span class="separator"></span>
                        </div>
                        <div class="column">
                            <div class="status {{$checks[3]}}">
                                <i class="check circle icon"></i> Shipped
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="ui basic history segment">
                    <div class="ui grid">
                        <div class="eight wide column">
                            <strong>Date/Time (UK)</strong>
                        </div>
                        <div class="eight wide column">
                            <strong>Activity</strong>
                        </div>

                        @if($order->messages->count())
                        @foreach($order->messages as $message)
                        <div class="eight wide column">
                            {{date('F d, o h:i', $message->created_at->timestamp)}}
                        </div>
                        <div class="eight wide column">
                            {{$message->message}}
                        </div>
                        @endforeach
                        @else
                        <div class="sixteen wide column">
                            No activity for the moment.
                        </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
@stop
