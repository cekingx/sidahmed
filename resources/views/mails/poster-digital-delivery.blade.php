@extends('mails.layouts.main')

@section('h2', 'Good News!')
@section('h3', 'Digital Delivery')

@section('message')

Hi {{$order->customer->name}}!<br/><br/>

Good news! Your poster is ready to download.<br/><br/>

Please click on the link below to open the download page. Once clicked the download link will remain active for the next 24 hours.<br/>
@endsection

@section('content')
@include('mails.layouts.components.button', ['url' => $order->tracker_url, 'text' => 'MY ORDER'])
@endsection