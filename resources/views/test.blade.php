<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<link rel="stylesheet" href="">
	{{-- <script src="https://banquemisr.gateway.mastercard.com/static/checkout/checkout.min.js" data-error="{{ url('/') }}" data-cancel="cancelCallback"></script> --}}
	<script src="https://banquemisr.gateway.mastercard.com/static/checkout/checkout.min.js" data-error="{{ url('/error') }}" data-cancel="{{ url('error') }}"></script>
	<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
	{{-- <script src="https://banquemisr.gateway.mastercard.com/static/checkout/checkout.min.js" data-error="errorCallback" data-cancel="cancelCallback"></script> --}}

	<script type="text/javascript">

		$(function() {
			function errorCallback(error) {
                  console.log(JSON.stringify(error));
            }
            function cancelCallback() {
                  console.log('Payment cancelled');
            }
			Checkout.configure({

			session: { 
				id: '{{ $sessionID }}'
			}
		});
		Checkout.showEmbeddedPage('#embed-target');
		});
	</script>
</head>
<body>

	<div id="embed-target"> </div> 

</body>
</html>