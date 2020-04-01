@extends('layouts.master', ['distraction_free' => true, 'header' => false])

@push('head')
	<link href="{{asset('css/Cashier.css')}}" rel="stylesheet" type="text/css">
@endpush


@section('content')
<div class="custompage">
<div class="ui container custombutton-block">
        <div class="ui buttons mrg-top250" style="">
                <button class="ui button">1</button>
                <div class=""><hr></div>
                <button class="ui button">2</button>
              </div>
  </div>



<div class="ui three column doubling grid container pad100 custom-html">
        <p class="custompara">Once you press <span style="color:#e9e52f">submit</span> you’ll receive 3 digit code. Please write this code in the personalisation/notes box. We need this code to connect your design with your Etsy order.</p>
 <?php $countIteam = 1; ?>
@foreach(\Cart::session(\Session::getId())->getContent() as $item)
  <div class="column imagebox">
    <div class="ui segment"><img class="ui medium image image-cart-map" src="{{$item->attributes->preview}}"><a href="{{route('cities::process.removeCart',$item->id)}}" class="removebtn">remove</a></div>
  </div>
  <?php $countIteam++; ?>
@endforeach
  
  <div class="column textBox imagebox">
        <div class="ui segment"><img class="ui medium image image-cart-map" src="{{asset('img/cashier/add_more.png')}}"><a href="{{route('cities::editor')}}">ADD {{$cartController->ordinal($countIteam)}} FOR ONLY £5</a></div>
  </div>
  <div class="submit-button-block"><a href="{{route('cart.createCustomOrder')}}" class="submit-button ui button">SUBMIT YOUR CUSTOM DESIGNS</a></div>
 
</div>

</div>
<?php /*<div class="ui grid">
	<div class="sixteen wide mobile six wide computer cart column">
		<div class="content">
			<p class="logo">Brand</p>

			<div class="ui product grid">
				@foreach(\Cart::session(\Session::getId())->getContent() as $item)
				<div class="seven wide preview column">
					<img src="{{$item->attributes->preview}}" class="ui image">
				</div>
				<div class="nine wide details column">
					<label>Location:</label> {{$item->attributes->location}}<br/>
					<label>Size:</label> {{round($item->attributes->size[0] * 0.0393701, 2)}}in x {{round($item->attributes->size[1] * 0.0393701, 2)}}in<br/>
					<label>Price:</label> ${{$item->price}}<br/>
					<label>Quantity:</label> <input class="quantity" type="number" value="{{$item->quantity}}" min="1" style="width:30px" data-item="{{$item->id}}">
				</div>
				@endforeach
			</div>

			<div class="ui divider"></div>

			<div class="ui basic right aligned segment">
				<h1 class="ui header">
					TOTAL: $<span id="cart_total">{{\Cart::session(\Session::getId())->getTotal()}}</span>
					<div class="sub header">
						NOTE: frame not included
					</div>
				</h1>
			</div>

			<div class="ui basic segment">
				<h4 class="ui header">
					SHIPPING SERVICE:
				</h4>

				<p>
					- Royal Mail 24 for UK Orders<br/>
					<small>Estimated delivery time: 1-3 working days</small><br/><br/>

					- RM Tracked for International Orders<br/>
					<small>Estimated delivery time: 5-10 working days</small><br/><br/>

					<small class="grey">Time may vary depending on country, seasonality, and custom checks.</small>
				</p>
			</div>
		</div>		
	</div>
	<div class="sixteen wide mobile ten wide computer checkout column">
		<div class="ui text container">
			<h1 class="ui inverted header">
				CHECKOUT
			</h1>

			<div class="ui short divider"></div>

			<p>
				Good news, the hard part is done! We need your shipping address and payment details to complete the order. To protect you we use Stripe to handle payments. Your card details are never shared with us.

				<br/><br/>

				Once your card is successfully received, we will start printing your order same day, if it was placed before 12 pm (BST) Monday to Friday.

				<br/><br/>

				<h4 class="ui inverted header">Shipping Information:</h4>

				<div class="ui grid">
					<div class="eight wide column">
						<form class="ui form" action="{{route('cart.checkout')}}" method="POST">
							<div class="field">
								<label>Email *</label>
								<input type="email" name="email" required/>
							</div>

							<div class="field">
								<label>Full name *</label>
								<input type="text" name="name" required/>
							</div>

							<div class="field">
								<label>Address (line 1) *</label>
								<input type="text" name="address_1" required/>
							</div>

							<div class="field">
								<label>Address (line 2) *</label>
								<input type="text" name="address_2" required/>
							</div>

							<div class="fields">
								<div class="field">
									<label>City / Town *</label>
									<input type="text" name="city" required/>
								</div>
								<div class="field">
									<label>Country</label>
									<div class="ui selection dropdown">
								        <input type="hidden" name="country">
								        <i class="dropdown icon"></i>
								        <div class="default text">Choose a country</div>
								        <div class="menu">
								            <div class="item">United Kingdom</div>
								            <div class="item">United States</div>
								        </div>
								    </div>
								</div>
							</div>

							<div class="fields">
								<div class="field">
									<label>Postal / Zip Code *</label>
									<input type="text" name="zipcode" required/>
								</div>
								<div class="field">
									<label>County / State *</label>
									<input type="text" name="state" required/>
								</div>
							</div>

							<div class="field">
							    <div class="ui checkbox">
							      	<input type="checkbox" tabindex="0" class="hidden" name="agreement">
							      	<label>
							      		By ticking this box you agree to our Terms of Service, Privacy Policy, and that you have provided us with the correct details.
							      	</label>
							    </div>
							</div>

							<div class="field">
								<button type="submit" class="ui primary huge fluid button">
									PURCHASE
								</button>
							</div>
						</form>
					</div>
					<div class="column">
					</div>
					<div class="six wide features column">
						<div class="feature">
							<img src="{{asset('img/cashier/icons/shipping.png')}}"/>
							<label>
								FREE SHIPPING<br/>
								FREE RETURNS
							</label>
						</div>
						<div class="feature">
							<img src="{{asset('img/cashier/icons/security.png')}}"/>
							<label>
								SECURE PAYMENT GATEWAY
							</label>
						</div>
						<div class="feature">
							<img src="{{asset('img/cashier/icons/delivery.png')}}"/>
							<label>
								FAST PROCESSING & DELIVERY
							</label>
						</div>
						<div class="feature">
							<img src="{{asset('img/cashier/icons/ltd.png')}}"/>
							<label>
								LTD REGISTERED 10148888
							</label>
						</div>
						<div class="feature">
							<img src="{{asset('img/cashier/icons/quality.png')}}"/>
							<label>
								BETTER THAN MUSEUM QUALITY 260GSM PAPER
							</label>
						</div>
					</div>
				</div>
			</p>
		</div>
	</div>
</div>*/ ?>

@endsection

@push('javascript')
	<script>
		window.Cart = {!! json_encode(\Cart::session(\Session::getId())->getContent()) !!};
	</script>

	<script src="{{asset('js/Cashier.js')}}"></script>
@endpush