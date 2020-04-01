@extends('mails.layouts.main')

@section('h2', 'Good News!')
@section('h3', 'Digital Delivery')

@section('message')
	Hi {{$order->customer->name}}!<br/><br/>

	Good news! Your poster has been dispatched today and should be with you shortly.<br/><br/>

	If you have purchased tracking service, your order will be updated with a tracking code, which you can find on Etsy.<br/>
@endsection

@section('content')

@include('mails.layouts.components.button', ['url' => '#', 'text' => 'MY ORDER'])
@endsection