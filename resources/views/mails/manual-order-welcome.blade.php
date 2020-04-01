@extends('mails.layouts.main')

@section('h2', 'Welcome!')
@section('h3', 'Thanks for buying with us')

@section('message')

Hi {{$order->customer->name}}!<br/><br/>

We've received your order. Thank you very much for supporting our little shop.<br/><br/>

We will send you a design proof shortly, which you will need to approve. We will wait 7 days for your response then process your order if we don't receive a response from you.<br/><br/>

You can find the exact status of your order by clicking on the link below.<br/>
@endsection

@section('content')
@include('mails.layouts.components.button', ['url' => $order->tracker_url, 'text' => 'MY ORDER'])
@endsection