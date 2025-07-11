



<!DOCTYPE html>
<html lang="zxx">
<head>
	@include('frontend.layouts.head')	
</head>
<style>
       
    </style>
<body class="js">
	
	<!-- Preloader -->
	<div class="preloader">
		<div class="preloader-inner">
			<div class="preloader-icon">
				<span></span>
				<span></span>
			</div>
		</div>
	</div>
	<!-- End Preloader -->
	
	@include('frontend.layouts.notification')
	<!-- Header -->
	@include('frontend.layouts.header')
	<!--/ End Header -->
	@yield('main-content')
        <!-- <div id="chat-box">
        <div id="messages"></div>
        <input type="text" id="user-input" placeholder="Bạn cần gì?" />
        <button onclick="sendMessage()">Gửi</button>
    </div>
    <div id="chat-box" style="width:300px; position:fixed; bottom:20px; right:20px; background:#f8f8f8; border-radius:10px; padding:10px; box-shadow:0 0 10px #ccc;">
        <div id="messages" style="max-height:200px; overflow-y:auto;"></div>
        <input type="text" id="user-input" placeholder="Bạn cần gì?" style="width:100%; margin-top:5px;">
        <button onclick="sendMessage()" style="width:100%; margin-top:5px;">Gửi</button>
    </div> -->



	
	@include('frontend.layouts.footer')

</body>

</html>
