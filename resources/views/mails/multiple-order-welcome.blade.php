@extends('mails.layouts.main')

@section('h2', 'Welcome!')
@section('h3', 'Thanks for buying with us')

@section('message')
Hi {{$order->customer->name}}!<br/><br/>

We've received your order. Thank you very much for supporting our little shop.<br/><br/>

Please click on the link below to start creating your posters. Once you are happy please click on the "Complete Order" button for us to start processing your order.<br/><br/>

After you've completed the order you will be able to track it by clicking this same button.<br/>
@endsection

@section('content')
@include('mails.layouts.components.button', ['url' => $order->order_url, 'text' => 'MY ORDER'])
@endsection