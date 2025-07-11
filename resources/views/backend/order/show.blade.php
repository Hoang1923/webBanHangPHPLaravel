@extends('backend.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="card">

  <div class="card-body">
    @if($order)
    <table class="table table-striped table-hover">
      <thead>
        <tr>
          <th>STT</th>
          <th>Số hóa đơn</th>
          <th>Tên khách hàng</th>
          <th>Email</th>
          <th>Số lượng</th>
          <th>Phí vận chuyển</th>
          <th>Tổng</th>
          <th>Trạng thái</th>
          <th>Thao tác</th>
        </tr>
      </thead>
      <tbody>
        <tr>
          <td>{{$order->id}}</td>
          <td>{{$order->order_number}}</td>
          <td>{{$order->first_name}} {{$order->last_name}}</td>
          <td>{{$order->email}}</td>
          <td>{{$order->quantity}}</td>
          @if($order->shipping)
          <td>{{ $order->shipping->price }}đ</td>
          @else
          <td>Không có</td>
          @endif

          <td>{{number_format($order->total_amount,0)}}đ</td>
          <td>
            @if($order->status=='new')
            <span class="badge badge-primary">{{$order->status}}</span>
            @elseif($order->status=='process')
            <span class="badge badge-warning">{{$order->status}}</span>
            @elseif($order->status=='delivered')
            <span class="badge badge-success">{{$order->status}}</span>
            @else
            <span class="badge badge-danger">{{$order->status}}</span>
            @endif
          </td>
          <td>
<a href="#" 
   class="btn btn-warning btn-sm float-left mr-1" 
   style="height:30px; width:30px;border-radius:50%" 
   data-toggle="modal" 
   data-target="#orderDetailsModal-{{ $order->id }}" 
   title="Xem chi tiết">
   <i class="fas fa-eye"></i>
</a>

            <a href="{{route('order.edit',$order->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
            {{-- <form method="POST" action="{{route('order.destroy',[$order->id])}}">--}}
            {{-- @csrf--}}
            {{-- @method('delete')--}}
            {{-- <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>--}}
            {{-- </form>--}}
          </td>

        </tr>
      </tbody>
    </table>
<div class="modal fade" id="orderDetailsModal-{{ $order->id }}" tabindex="-1" role="dialog" aria-labelledby="orderDetailsModalLabel-{{ $order->id }}" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="orderDetailsModalLabel-{{ $order->id }}">Chi tiết đơn hàng #{{ $order->order_number }}</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Đóng">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        
<ul class="list-group shopping-list">
    @foreach($order->orderDetails as $detail)
        @php
            $photos = explode(',', $detail->product->photo);
        @endphp
        <li class="list-group-item d-flex align-items-center">
            <a href="{{ route('product-detail', $detail->product->slug) }}" target="_blank" class="me-3" style="width: 80px; flex-shrink: 0;">
                <img src="{{ secure_asset($photos[0]) }}" alt="{{ $detail->product->title }}" class="img-fluid rounded" style="max-height: 80px; object-fit: cover;">
            </a>
            <div class="flex-grow-1">
                <h5 class="mb-1">
                    <a href="{{ route('product-detail', $detail->product->slug) }}" target="_blank" class="text-decoration-none text-dark">
                        {{ $detail->product->title }}
                    </a>
                </h5>
                <p class="mb-0 text-muted">
                    <span class="fw-semibold">{{ $detail->quantity }} x</span>
                    <span class="text-danger fw-bold">{{ number_format($detail->price, 0, ',', '.') }}đ</span>
                </p>
            </div>
        </li>
    @endforeach
</ul>


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Đóng</button>
      </div>
    </div>
  </div>
</div>

    <section class="confirmation_part section_padding">
      <div class="order_boxes">
        <div class="row">
          <div class="col-lg-6 col-lx-4">
            <div class="order-info">
              <h4 class="text-center pb-4">Thông tin đơn hàng</h4>
              <table class="table">
                <tr class="">
                  <td>Số hóa đơn</td>
                  <td> : {{$order->order_number}}</td>
                </tr>
                <tr>
                  <td>Ngày đặt hàng</td>
                  <td> : {{$order->created_at->format('D d M, Y')}} at {{$order->created_at->format('g : i a')}} </td>
                </tr>
                <tr>
                  <td>Số lượng</td>
                  <td> : {{$order->quantity}}</td>
                </tr>
                <tr>
                  <td>Trạng thái đơn hàng</td>
                  <td> : {{$order->status}}</td>
                </tr>
                <tr>
                  <td>Phí vận chuyển</td>
                  @if($order->shipping)
                  <td>: {{ $order->shipping->price }}đ</td>
                  @else
                  <td>: Không có</td>
                  @endif

                </tr>
                <tr>
                  <td>Mã giảm giá</td>
                  <td> : {{number_format($order->coupon,0)}}đ</td>
                </tr>
                <tr>
                  <td>Tổng tiền</td>
                  <td> : {{number_format($order->total_amount,0)}}đ</td>
                </tr>
                <tr>
                  <td>Phương thức thanh toán</td>
                  <td> : @if($order->payment_method=='cod') Thanh toán khi nhận hàng @else Chuyển khoản ngân hàng @endif</td>
                </tr>
                <tr>
                  <td>Trạng thái thanh toán</td>
                  <td> : 
  @if($order->payment_status === 'paid')
    <span class="badge badge-success">Đã thanh toán</span>
  @else
    <span class="badge badge-warning">Chưa thanh toán</span>
  @endif
</td>

                </tr>
              </table>
            </div>
          </div>

          <div class="col-lg-6 col-lx-4">
            <div class="shipping-info">
              <h4 class="text-center pb-4">Thông tin giao hàng</h4>
              <table class="table">
                <tr class="">
                  <td>Tên đầy đủ</td>
                  <td> : {{$order->first_name}} {{$order->last_name}}</td>
                </tr>
                <tr>
                  <td>Email</td>
                  <td> : {{$order->email}}</td>
                </tr>
                <tr>
                  <td>Số điện thoại</td>
                  <td> : {{$order->phone}}</td>
                </tr>
                <tr>
                  <td>Địa chỉ</td>
                  <td> : {{$order->address1}}, {{$order->address2}}</td>
                </tr>
                <tr>
                  <td>Quốc Gia</td>
                  <td> : {{$order->country}}</td>
                </tr>
                <tr>
                  <td>Mã bưu điện</td>
                  <td> : {{$order->post_code}}</td>
                </tr>
              </table>
            </div>
          </div>
        </div>
      </div>
    </section>
    @endif

  </div>
</div>
@endsection

@push('styles')
<style>
  .order-info,
  .shipping-info {
    background: #ECECEC;
    padding: 20px;
  }

  .order-info h4,
  .shipping-info h4 {
    text-decoration: underline;
  }
</style>
@endpush