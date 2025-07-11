
	<!-- Start Footer Area -->
	<footer class="footer">
		<!-- Footer Top -->
		<div class="footer-top section" style="padding-bottom: 50px; padding-top: 50px">
			<div class="container">
				<div class="row">
					<div class="col-lg-5 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer about">
							<div class="logo">
								<a href="index.html"><img src="{{secure_asset('/storage/photos/33/LOGO_Footer_1.png')}}" alt="#"></a>
							</div>
							@php
								$settings=DB::table('settings')->get();
							@endphp
							<p class="text">@foreach($settings as $data) {{$data->short_des}} @endforeach</p>
							<p class="call">Nếu bạn có câu hỏi? Gọi ngay cho chúng tôi.<span style="margin-top: 10px"><a href="tel:0398314279" >@foreach($settings as $data) {{$data->phone}} @endforeach</a></span></p>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Thông tin</h4>
							<ul>
								<li><a href="{{route('about-us')}}">Thông Tin</a></li>
								<li><a href="#">FaQ</a></li>
								<li><a href="#">Điều Khoản & Điều Kiện</a></li>
								<li><a href="{{route('contact')}}">Liên Hệ</a></li>
								<li><a href="#">Hỗ Trợ</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-2 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer links">
							<h4>Dịch Vụ</h4>
							<ul>
								<li><a href="#">Phương Thức Thanh Toán</a></li>
								<li><a href="#">Hoàn Trả Tiền</a></li>
								<li><a href="#">Hoàn Trả</a></li>
								<li><a href="#">Giao Hàng</a></li>
								<li><a href="#">Chính Sách Bảo Mật</a></li>
							</ul>
						</div>
						<!-- End Single Widget -->
					</div>
					<div class="col-lg-3 col-md-6 col-12">
						<!-- Single Widget -->
						<div class="single-footer social">
							<h4>Liên Hệ</h4>
							<!-- Single Widget -->
							<div class="contact">
								<ul>
									<li>Địa chỉ: Trâu Quỳ - Gia Lâm - Hà Nội</li>
									<li>Email: danghoang1192003@gmail.com</li>
									<li>SĐT: 0797968619 - 0796364178</li>
								</ul>
							</div>
							<!-- End Single Widget -->
                            <br>
                            <h6>Follow Me</h6>
							<!-- <div class="sharethis-inline-share-buttons"></div> -->
						</div>
						<!-- End Single Widget -->
					</div>
				</div>
			</div>
		</div>
		<!-- End Footer Top -->
		<div class="copyright">
			<div class="container">
				<div class="inner">
					<div class="row">
						<div class="col-lg-6 col-12">
							<div class="left">
								<p>Copyright © {{date('Y')}} <a href="https://www.facebook.com/hgpeki2819" target="_blank">Đặng Văn Hoàng</a>  -  All Rights Reserved.</p>
							</div>
						</div>
						<!-- <div class="col-lg-6 col-12">
							<div class="right">
								<img src="{{secure_asset('backend/img/payments.png')}}" alt="#">
							</div>
						</div> -->
					</div>
				</div>
			</div>
		</div>
	</footer>
	<!-- /End Footer Area -->

	<!-- Jquery -->



    <script src="{{secure_asset('frontend/js/jquery.min.js')}}"></script>
    <script src="{{secure_asset('frontend/js/jquery-migrate-3.0.0.js')}}"></script>
	<script src="{{secure_asset('frontend/js/jquery-ui.min.js')}}"></script>
	<!-- Popper JS -->
	<script src="{{secure_asset('frontend/js/popper.min.js')}}"></script>
	<!-- Bootstrap JS -->
	<script src="{{secure_asset('frontend/js/bootstrap.min.js')}}"></script>
	<!-- Color JS -->
	<script src="{{secure_asset('frontend/js/colors.js')}}"></script>
	<!-- Slicknav JS -->
	<script src="{{secure_asset('frontend/js/slicknav.min.js')}}"></script>
	<!-- Owl Carousel JS -->
	<script src="{{secure_asset('frontend/js/owl-carousel.js')}}"></script>
	<!-- Magnific Popup JS -->
	<script src="{{secure_asset('frontend/js/magnific-popup.js')}}"></script>
	<!-- Waypoints JS -->
	<script src="{{secure_asset('frontend/js/waypoints.min.js')}}"></script>
	<!-- Countdown JS -->
	<script src="{{secure_asset('frontend/js/finalcountdown.min.js')}}"></script>
	<!-- Nice Select JS -->
	<script src="{{secure_asset('frontend/js/nicesellect.js')}}"></script>
	<!-- Flex Slider JS -->
	<script src="{{secure_asset('frontend/js/flex-slider.js')}}"></script>
	<!-- ScrollUp JS -->
	<script src="{{secure_asset('frontend/js/scrollup.js')}}"></script>
	<!-- Onepage Nav JS -->
	<script src="{{secure_asset('frontend/js/onepage-nav.min.js')}}"></script>
	{{-- Isotope --}}
	<script src="{{secure_asset('frontend/js/isotope/isotope.pkgd.min.js')}}"></script>
	<!-- Easing JS -->
	<script src="{{secure_asset('frontend/js/easing.js')}}"></script>

	<!-- Active JS -->
	<script src="{{secure_asset('frontend/js/active.js')}}"></script>


	@stack('scripts')
	<script>
		setTimeout(function(){
		  $('.alert').slideUp();
		},5000);
		$(function() {
		// ------------------------------------------------------- //
		// Multi Level dropdowns
		// ------------------------------------------------------ //
			$("ul.dropdown-menu [data-toggle='dropdown']").on("click", function(event) {
				event.preventDefault();
				event.stopPropagation();

				$(this).siblings().toggleClass("show");


				if (!$(this).next().hasClass('show')) {
				$(this).parents('.dropdown-menu').first().find('.show').removeClass("show");
				}
				$(this).parents('li.nav-item.dropdown.show').on('hidden.bs.dropdown', function(e) {
				$('.dropdown-submenu .show').removeClass("show");
				});

			});
		});
	  </script>
