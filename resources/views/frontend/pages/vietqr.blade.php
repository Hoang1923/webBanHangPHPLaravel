<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán qua VietQR</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
       
    .fade-out {
        transition: opacity 1s ease-out;
        opacity: 1;
    }

    .fade-out.hidden {
        opacity: 0;
    }


    .popup {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: rgba(0, 0, 0, 0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 9999;
    }

    .popup.hidden {
        display: none;
    }

    .popup-content {
        background-color: #fff;
        padding: 30px 40px;
        border-radius: 10px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        animation: fadeIn 0.5s ease;
    }

    .popup-content .icon {
        font-size: 3rem;
        color: #28a745; /* Bootstrap's green */
        margin-bottom: 10px;
    }

    .popup-content p {
        font-size: 1.4rem;
        font-weight: bold;
        color: #28a745;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: scale(0.9); }
        to { opacity: 1; transform: scale(1); }
    }
.success {
    color: green;
}


    </style>
</head>
<body>
    <!-- Popup xác nhận thanh toán -->
<div id="payment-success-popup" class="popup hidden">
    <div class="popup-content">
        <div class="icon">&#10004;</div> <!-- ✔ -->
        <p>Đã nhận thanh toán. Đang chuyển hướng...</p>
    </div>
</div>

<div class="container py-5 text-center">
    <h3 class="mb-4 success">Cảm ơn bạn đã đặt hàng!</h3>
    <p class="mb-3">Mã đơn hàng: <strong>#{{ $order->order_number }}</strong></p>
    <p>Số tiền cần chuyển khoản: <strong>{{ number_format($amount, 0, ',', '.') }} VNĐ</strong></p>
    <p>Chủ tài khoản: <strong>{{ $accountName }}</strong></p>
    <p>Số tài khoản: <strong>{{ $accountNumber }}</strong></p>
    <p>Nội dung chuyển khoản: <strong>{{ $description }}</strong></p>

    <div class="my-4">
        <img src="{{ $qrUrl }}" alt="QR Code VietQR" style="max-width: 300px;">
    </div>

    <p>Vui lòng quét mã QR để chuyển khoản.</p>

    @if ($order->payment_status === 'paid')
        <p style="scale: 3;" class="text-success">Bạn đã thanh toán thành công.</p>
        <script>
            setTimeout(() => {
                window.location.href = "{{ route('home') }}";
            }, 1500);
        </script>
    @else
        <p id="checking" class="text-muted">
            <span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>
            Đang kiểm tra thanh toán...
        </p>
         <!-- <script>
        setInterval(() => {
            location.reload();
        }, 2000); // Reload sau mỗi 2 giây
    </script> -->

        <!-- <script>
    const orderId = "{{ $order->id }}";

    setInterval(() => {
        fetch(`/check-payment-status/${orderId}?t=${Date.now()}`) // tránh cache
            .then(res => {
                if (!res.ok) throw new Error("Lỗi kết nối");
                return res.json();
            })
            .then(data => {
                if (data.paid) {
                    const checkingElement = document.getElementById("checking");

                    // Cập nhật nội dung + thay đổi màu + tăng cỡ chữ
                    checkingElement.innerText = "Đã nhận thanh toán. Đang chuyển hướng...";
                    checkingElement.classList.remove("text-muted");
                    checkingElement.classList.add("text-success", "fade-out");
                    checkingElement.style.fontSize = "1.5rem";
                    checkingElement.style.fontWeight = "bold";

                    // Sau một khoảng thời gian, thêm lớp 'hidden' để làm mờ dần
                    setTimeout(() => {
                        checkingElement.classList.add("hidden");
                    }, 1000); // Delay 1 giây trước khi fade-out

                    // Chuyển hướng sau 1.5 giây
                    setTimeout(() => {
                        window.location.href = "{{ route('home') }}";
                    }, 1500);
                }
            })
            .catch(err => {
                console.warn("Không thể kiểm tra thanh toán:", err);
            });
    }, 5000);
</script> -->
<script>
    const orderId = "{{ $order->id }}";
    const successSound = new Audio("{{ asset('images/success.mp3') }}"); 

    setInterval(() => {
        fetch(`/check-payment-status/${orderId}?t=${Date.now()}`)
            .then(res => {
                if (!res.ok) throw new Error("Lỗi kết nối");
                return res.json();
            })
            .then(data => {
                if (data.paid) {
                     successSound.play();
                    // 1. Làm mờ dòng "Đang kiểm tra thanh toán..."
                    const checkingElement = document.getElementById("checking");
                    if (checkingElement) {
                        checkingElement.classList.add("fade-out");
                        setTimeout(() => {
                            checkingElement.classList.add("hidden"); 
                        }, 1);
                    }

                    // 2. Hiển thị popup
                    const popup = document.getElementById("payment-success-popup");
                    if (popup) {
                        popup.classList.remove("hidden");
                    }

                    // 3. Chuyển hướng sau 1.5s
                    setTimeout(() => {
                        window.location.href = "{{ route('home') }}";
                    }, 1500);
                }
            })
            .catch(err => {
                console.warn("Không thể kiểm tra thanh toán:", err);
            });
    }, 5000);
</script>



    @endif
</div>
</body>
</html>
