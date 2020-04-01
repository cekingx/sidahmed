@extends('mails.layouts.main')

@section('h2', 'Good news!')
@section('h3', 'Status Update')

@section('message')

Hi {{$order->customer->name}},<br/><br/>

There has been an update to your order. Please click on the link below to view the new order status.<br/>
@endsection

@section('content')
@include('mails.layouts.components.button', ['url' => $order->tracker_url, 'text' => 'MY ORDER'])
@endsection