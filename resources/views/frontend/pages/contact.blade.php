@extends('frontend.layouts.master')

@section('title','Jelly-Boutique || Liên Hệ')

@section('main-content')
	<!-- Breadcrumbs -->
	<div class="breadcrumbs">
		<div class="container">
			<div class="row">
				<div class="col-12">
					<div class="bread-inner">
						<ul class="bread-list">
							<li><a href="{{route('home')}}">Trang Chủ<i class="ti-arrow-right"></i></a></li>
							<li class="active"><a href="javascript:void(0);">Liên Hệ</a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- End Breadcrumbs -->

	<!-- Start Contact -->
	<section id="contact-us" class="contact-us section">
		<div class="container">
				<div class="contact-head">
					<div class="row">
						<div class="col-lg-8 col-12">
							<div class="form-main">
								<div class="title">
									@php
										$settings=DB::table('settings')->get();
									@endphp
									<h4>Liên Lạc</h4>
									<h3>Gửi cho chúng tôi một tin nhắn @auth @else<span style="font-size:12px;" class="text-danger">[Bạn cần phải đăng nhập để tiếp tục]</span>@endauth</h3>
								</div>
								<form class="form-contact form contact_form" method="post" action="{{route('contact.store')}}" id="contactForm" novalidate="novalidate">
									@csrf
									<div class="row">
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Họ Tên<span>*</span></label>
												<input name="name" id="name" type="text" placeholder="Nhập họ tên của bạn">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Bạn cần thông tin về sản phẩm/dịch vụ gì ?<span>*</span></label>
												<input name="subject" type="text" id="subject" placeholder="Nhập thông tin">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Email của bạn<span>*</span></label>
												<input name="email" type="email" id="email" placeholder="Nhập Email của bạn">
											</div>
										</div>
										<div class="col-lg-6 col-12">
											<div class="form-group">
												<label>Số điện thoại<span>*</span></label>
												<input id="phone" name="phone" type="number" placeholder="Nhập số điện thoại của bạn">
											</div>
										</div>
										<div class="col-12">
											<div class="form-group message">
												<label>Nội dung<span>*</span></label>
												<textarea name="message" id="message" cols="30" rows="9" placeholder="Nhập nội dung"></textarea>
											</div>
										</div>
										<div class="col-12">
											<div class="form-group button">
												<button type="submit" class="btn ">Gửi tin nhắn</button>
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
						<div class="col-lg-4 col-12">
							<div class="single-head">
								<div class="single-info">
									<i class="fa fa-phone"></i>
									<h4 class="title">Gọi cho chùng tôi ngay:</h4>
									<ul>
										<li>@foreach($settings as $data) {{$data->phone}} @endforeach</li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-envelope-open"></i>
									<h4 class="title">Email:</h4>
									<ul>
										<li><a href="mailto:info@yourwebsite.com">@foreach($settings as $data) {{$data->email}} @endforeach</a></li>
									</ul>
								</div>
								<div class="single-info">
									<i class="fa fa-location-arrow"></i>
									<h4 class="title">Địa chỉ của chúng tôi:</h4>
									<ul>
										<li>@foreach($settings as $data) {{$data->address}} @endforeach</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
	</section>
	<!--/ End Contact -->

	<!-- Map Section -->
	<!-- <div class="map-section">
		<div id="myMap">
			<iframe src="https://www.google.com/maps/place/H%E1%BB%8Dc+vi%E1%BB%87n+N%C3%B4ng+Nghi%E1%BB%87p+Vi%E1%BB%87t+Nam/@21.0050582,105.9268934,1293m/data=!3m2!1e3!4b1!4m6!3m5!1s0x3135a94c1f882977:0x6d016e6656923f46!8m2!3d21.0050533!4d105.9317643!16s%2Fm%2F0cr4831?entry=ttu&g_ep=EgoyMDI1MDQzMC4xIKXMDSoASAFQAw%3D%3D" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
		</div>
	</div> -->
	<!--/ End Map Section -->



        <!-- Start Shop Newsletter  -->
	@include('frontend.layouts.newsletter')
	<!-- End Shop Newsletter -->
	<!--================Contact Success  =================-->
	<div class="modal fade" id="success" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<h2 class="text-success">Xin cảm ơn!</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="text-success">Tin nhắn của bạn đã được gửi thành công...</p>
			</div>
		  </div>
		</div>
	</div>

	<!-- Modals error -->
	<div class="modal fade" id="error" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
		  <div class="modal-content">
			<div class="modal-header">
				<h2 class="text-warning">Sorry!</h2>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="text-warning">Có một vài lỗi trong quá trình thực hiện.</p>
			</div>
		  </div>
		</div>
	</div>
@endsection

@push('styles')
<style>
	.modal-dialog .modal-content .modal-header{
		position:initial;
		padding: 10px 20px;
		border-bottom: 1px solid #e9ecef;
	}
	.modal-dialog .modal-content .modal-body{
		height:100px;
		padding:10px 20px;
	}
	.modal-dialog .modal-content {
		width: 50%;
		border-radius: 0;
		margin: auto;
	}
</style>
@endpush
@push('scripts')
<script src="{{ secure_asset('frontend/js/jquery.form.js') }}"></script>
<script src="{{ secure_asset('frontend/js/jquery.validate.min.js') }}"></script>
<script src="{{ secure_asset('frontend/js/contact.js') }}"></script>
@endpush
