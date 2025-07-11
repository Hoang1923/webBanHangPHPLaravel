@extends('frontend.layouts.master')

@section('title','Jelly-Boutique || Thanh Toán')

@section('main-content')
<style>
    .modal-dialog {
        max-width: 700px;
        /* tùy chỉnh chiều ngang */
        margin-top: 100px;
    }

    /* .modal-content {
    height: 80vh; 
    overflow: hidden; 
    border-radius: 12px;
} */
</style>

<!-- Breadcrumbs -->
<div class="breadcrumbs">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="bread-inner">
                    <ul class="bread-list">
                        <li><a href="{{route('home')}}">Trang Chủ<i class="ti-arrow-right"></i></a></li>
                        <li class="active"><a href="javascript:void(0)">Thanh Toán</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Breadcrumbs -->

<!-- Start Checkout -->
<section class="shop checkout section">
    <div class="container">
        <form class="form" method="POST" action="{{route('cart.order')}}">
            @csrf
            <div class="row">

                <div class="col-lg-8 col-12">
                    <div class="checkout-form">
                        <h2>Thực Hiện Thanh Toán</h2>
                        <p>Vui lòng đăng ký để việc thanh toán nhanh chóng hơn.</p>
                        <!-- Form -->
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Tên<span>*</span></label>
                                    <input type="text" name="first_name" placeholder="" value="{{old('first_name')}}" value="{{old('first_name')}}">
                                    @error('first_name')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Họ<span>*</span></label>
                                    <input type="text" name="last_name" placeholder="" value="{{old('lat_name')}}">
                                    @error('last_name')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Địa chỉ Email<span>*</span></label>
                                    <input type="email" name="email" placeholder="" value="{{old('email')}}">
                                    @error('email')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Số điện thoại <span>*</span></label>
                                    <input type="number" name="phone" placeholder="" required value="{{old('phone')}}">
                                    @error('phone')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Quốc Gia<span>*</span></label>
                                    <select name="country" id="country">

                                        <option value="VN">Vietnam</option>
                                        <option value="WF">Mỹ</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Địa chỉ 1<span>*</span></label>
                                    <input type="text" name="address1" placeholder="" value="{{old('address1')}}">
                                    @error('address1')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Địa chỉ 2</label>
                                    <input type="text" name="address2" placeholder="" value="{{old('address2')}}">
                                    @error('address2')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6 col-12">
                                <div class="form-group">
                                    <label>Mã bưu chính</label>
                                    <input type="text" name="post_code" placeholder="" value="{{old('post_code')}}">
                                    @error('post_code')
                                    <span class='text-danger'>{{$message}}</span>
                                    @enderror
                                </div>
                            </div>

                        </div>
                        <!--/ End Form -->
                    </div>
                </div>
                <div class="col-lg-4 col-12">
                    <div class="order-details">
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>Tổng Tiền Giỏ Hàng</h2>
                            <div class="content">
                                <ul>
                                    <li class="order_subtotal" data-price="{{Helper::totalCartPrice()}}">Tiền Sản Phẩm<span>{{number_format(Helper::totalCartPrice(),0)}}đ</span></li>
                                    <li class="shipping">
                                        Phí Giao Hàng
                                        @if(count(Helper::shipping())>0 && Helper::cartCount()>0)
                                        <select name="shipping" class="nice-select">
                                            <option value="">Lựa chọn địa chỉ của bạn</option>
                                            @foreach(Helper::shipping() as $shipping)
                                            <option value="{{$shipping->id}}" class="shippingOption" data-price="{{$shipping->price}}">{{$shipping->type}}: {{$shipping->price}}đ</option>
                                            @endforeach
                                        </select>
                                        @else
                                        <span>Miễn Phí</span>
                                        @endif
                                    </li>

                                    @if(session('coupon'))
                                    <li class="coupon_price" data-price="{{session('coupon')['value']}}">Bạn tiết kiệm được<span>{{number_format(session('coupon')['value'],0)}}đ</span></li>
                                    @endif
                                    @php
                                    $total_amount=Helper::totalCartPrice();
                                    if(session('coupon')){
                                    $total_amount=$total_amount-session('coupon')['value'];
                                    }
                                    @endphp
                                    @if(session('coupon'))
                                    <li class="last" id="order_total_price">Tổng Tiền<span>{{number_format($total_amount,0)}}đ</span></li>
                                    @else
                                    <li class="last" id="order_total_price">Tổng Tiền<span>{{number_format($total_amount,0)}}đ</span></li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                        <!--/ End Order Widget -->
                        <!-- Order Widget -->
                        <div class="single-widget">
                            <h2>Payments</h2>
                            <div class="content">
                                <div class="checkbox">
                                    <div class="form-group">
                                        <input style="width: 20px; height: 20px;" type="radio" name="payment_method" value="cod" id="pm_cod" checked>
                                        <label for="pm_cod">Thanh Toán Khi Giao Hàng</label><br>

                                        <input style="width: 20px; height: 20px;" type="radio" name="payment_method" value="bank_transfer" id="pm_bank">
                                        <label for="pm_bank">Chuyển khoản ngân hàng</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Button Thanh Toán -->
                        <div class="single-widget get-button">
                            <div class="content">
                                <div class="button">
                                    <button type="submit" class="btn">Thanh Toán</button>
                                </div>
                            </div>
                        </div>
                        <!-- Popup QR -->
                        
                        <!--/ End Payment Method Widget -->
                        <!-- Button Widget -->
                        <!-- <div class="single-widget get-button">
                            <div class="content">
                                <div class="button">
                                    <button type="submit" class="btn">Thanh Toán</button>
                                </div>
                            </div>
                        </div> -->
                        <!--/ End Button Widget -->
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--/ End Checkout -->

<!-- Start Shop Services Area -->
<section class="shop-services section home">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-rocket"></i>
                    <h4>Miễn Phí Giao Hàng</h4>
                    <p>Cho đơn hàng trên 1.000.000 đ</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-reload"></i>
                    <h4>Miễn Phí Hoàn Trả</h4>
                    <p>Trong vòng 30 ngày</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-lock"></i>
                    <h4>Bảo Mật Thanh Toán</h4>
                    <p>100% Bảo Mật Thanh Toán</p>
                </div>
                <!-- End Single Service -->
            </div>
            <div class="col-lg-3 col-md-6 col-12">
                <!-- Start Single Service -->
                <div class="single-service">
                    <i class="ti-tag"></i>
                    <h4>Giá Tốt Nhất</h4>
                    <p>Đảm Bảo Giá Tốt Nhất</p>
                </div>
                <!-- End Single Service -->
            </div>
        </div>
    </div>
</section>
<!-- End Shop Services Area -->

<!-- Start Shop Newsletter  -->
<section class="shop-newsletter section" style="padding-top: 0px">
    <div class="container">
        <div class="inner-top">
            <div class="row">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <!-- Start Newsletter Inner -->
                    <div class="inner">
                        <h4>Tin Tức</h4>
                        <p> Đăng ký nhận thông báo tin tức mới nhất và được giảm giá <span>10%</span> giá trị đơn hàng đầu tiên</p>
                        <form action="{{route('subscribe')}}" method="post" class="newsletter-inner">
                            @csrf
                            <input name="email" placeholder="Nhập Email của bạn...." required="" type="email">
                            <button class="btn" type="submit">Đăng Ký</button>
                        </form>
                    </div>
                    <!-- End Newsletter Inner -->
                </div>
            </div>
        </div>
    </div>
</section>
<!-- End Shop Newsletter -->
@endsection
@push('styles')
<style>
    li.shipping {
        display: inline-flex;
        width: 100%;
        font-size: 14px;
    }

    li.shipping .input-group-icon {
        width: 100%;
        margin-left: 10px;
    }

    .input-group-icon .icon {
        position: absolute;
        left: 20px;
        top: 0;
        line-height: 40px;
        z-index: 3;
    }

    .form-select {
        height: 30px;
        width: 100%;
    }

    .form-select .nice-select {
        border: none;
        border-radius: 0px;
        height: 40px;
        background: #f6f6f6 !important;
        padding-left: 45px;
        padding-right: 40px;
        width: 100%;
    }

    .list li {
        margin-bottom: 0 !important;
    }

    .list li:hover {
        background: #F7941D !important;
        color: white !important;
    }

    .form-select .nice-select::after {
        top: 14px;
    }
</style>
@endpush
@push('scripts')
<script src="{{secure_asset('frontend/js/nice-select/js/jquery.nice-select.min.js')}}"></script>
<script src="{{ secure_asset('frontend/js/select2/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $("select.select2").select2();
    });
    $('select.nice-select').niceSelect();
</script>
<script>
    function showMe(box) {
        var checkbox = document.getElementById('shipping').style.display;
        // alert(checkbox);
        var vis = 'none';
        if (checkbox == "none") {
            vis = 'block';
        }
        if (checkbox == "block") {
            vis = "none";
        }
        document.getElementById(box).style.display = vis;
    }
</script>
<script>
    $(document).ready(function() {
        $('.shipping select[name=shipping]').change(function() {
            let cost = parseFloat($(this).find('option:selected').data('price')) || 0;
            let subtotal = parseFloat($('.order_subtotal').data('price'));
            let coupon = parseFloat($('.coupon_price').data('price')) || 0;
            // alert(coupon);
            $('#order_total_price span').text((subtotal + cost - coupon).toFixed(0) + 'đ');
        });

    });
</script>

<!-- <script>
  document.addEventListener('DOMContentLoaded', function () {
    const form = document.querySelector('.form');
    const payButton = form.querySelector('.btn');
    const qrPopup = document.getElementById('qrPopup');
    const paymentSuccessBtn = document.getElementById('paymentSuccessBtn');
    const closePopupBtn = document.getElementById('closePopupBtn');

    form.addEventListener('submit', function (e) {
      // Lấy phương thức thanh toán đang chọn
      const paymentMethod = document.querySelector('input[name="payment_method"]:checked').value;

      if (paymentMethod === 'bank_transfer') {
        // Nếu chọn chuyển khoản ngân hàng, chặn submit và mở popup
        e.preventDefault();
        qrPopup.style.display = 'flex';
      }
      // Nếu chọn "Thanh toán khi giao hàng" ➜ không chặn, form vẫn submit bình thường
    });

    // Nút "Tôi đã thanh toán thành công"
    paymentSuccessBtn.addEventListener('click', function () {
      qrPopup.style.display = 'none';
      // Sau khi đã thanh toán thành công ➜ submit form
      form.submit();
    });

    // Nút "Đóng"
    closePopupBtn.addEventListener('click', function () {
      qrPopup.style.display = 'none';
    });
  });
</script> -->


<!-- <script>
    document.addEventListener('DOMContentLoaded', function() {
        const bankRadio = document.getElementById('pm_bank');
        const codRadio = document.getElementById('pm_cod');

        bankRadio.addEventListener('change', function() {
            if (this.checked) {
                $('#qrModal').modal('show');
            }
        });

        $('#qrModal').on('hidden.bs.modal', function() {
            // Khi popup bị đóng, quay lại chọn COD
            codRadio.checked = true;
        });
    });
</script> -->




@endpush