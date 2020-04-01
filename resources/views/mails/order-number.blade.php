@extends('mails.layouts.main')

@section('h2', 'Good news!')
@section('h3', 'Order Code')

@section('message')

Hi ,<br/><br/>

<p><b>Order Code : {{$orderNumber}} </b> </p>

<p>Copy and Paste this code into the personalisation/notes box when you order. </p>
<p>We need this code to connect your design with your Etsy order. </p>
<p>We only accept payment via Etsy.</p>

<br>
Thanks
@endsection

@section('content')
@endsection