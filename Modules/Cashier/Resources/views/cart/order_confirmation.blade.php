@extends('layouts.master', ['distraction_free' => true, 'header' => false])

@push('head')
	<link href="{{asset('css/Cashier.css')}}" rel="stylesheet" type="text/css">
@endpush


@section('content')
<div class="custompage">
<div class="ui container custombutton-block">
        <div class="ui buttons" style="">
                <button class="ui button">1</button>
                <div class=""><hr></div>
                <button class="ui button">2</button>
              </div>
  </div>



<div class="ui three column doubling grid container pad100 custom-html">
        <p class="custompara2">Copy and Paste this code into the personalisation/notes box when you order. We need this code to connect your design with your <span style="color: #f1641e;">Etsy</span> order. We only accept payment via Etsy.</p>
<div class="customCopyBlock">
        <div class="ui action input">
                <input type="text" readonly="" value="{{$customOrdersDetail['order_number']}}" placeholder="" class="customTextbox" id="order-number-to"  >
                <button class="ui button" onclick="copyOrderNumber()">Copy</button>
              </div>

</div>
 
  <div class="back-button-block"><a href="{{$redirectLink}}" class="back-button ui button">back to etsy</a><button class="email-button ui button email-me-code-button">email me the code</button>
<div class="ui action input email-code-div" style="display: none;">
                <input type="email" value="" placeholder="ENTER EMAIL ADDRESS HERE" class="customTextbox" id="email-to"  >
                <button class="ui button send-code-email" id="send-code-email">Send</button>
              </div>
  </div>

 
</div>

</div>

@endsection

@push('javascript')
	<script>
		window.Cart = {!! json_encode(\Cart::session(\Session::getId())->getContent()) !!};
		function copyOrderNumber() {
			  /* Get the text field */
			  var copyText = document.getElementById("order-number-to");

			  /* Select the text field */
			  copyText.select();
			  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

			  /* Copy the text inside the text field */
			  document.execCommand("copy");
			  toastr.success('Order number has been copied to clipboard!')
			}
	$(document).ready(function(){
		$(document).on("click","#send-code-email",function(){
			var emailId = $("#email-to").val();
			var orderNumber = $("#order-number-to").val();
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  			 if(emailId.trim() == ""){
  				toastr.error('Please enter email address!');
  			 }
  			 else if(!regex.test(emailId)){
  				toastr.error('Please enter valid email address!');
  			return false;
  			}
  			else{
			$.ajax({
						url: "{{route('cart.sendOrderCodeEmail')}}",
						type: "POST",
						data: {email:emailId,orderNumber:orderNumber},

						success: function success(e) {
							 toastr.success('Email has been sent!')
						}
					});
  				
  			}
		});

		$(document).on("click",".email-me-code-button",function(){
			$(this).hide();
			$(".email-code-div").show();
		})
	})
	</script>

	<script src="{{asset('js/Cashier.js')}}"></script>
@endpush