@extends('user.layouts.master')

@section('main-content')
<!-- DataTales Example -->
<div class="card shadow mb-4">
  <div class="row">
    <div class="col-md-12">
      @include('user.layouts.notification')
    </div>
  </div>
  <div class="card-header py-3">
    <h6 class="m-0 font-weight-bold text-primary float-left">Danh sách đơn hàng</h6>
  </div>
  <div class="card-body">
    <div class="table-responsive">
      @if(count($orders)>0)
      <table class="table table-bordered" id="order-dataTable" width="100%" cellspacing="0">
        <thead>
          <tr>
            <th>STT</th>
            <th>Mã đơn hàng</th>
            <th>Tên</th>
            <th>Email</th>
            <th>Số lượng</th>
            <th>Phí vận chuyển</th>
            <th>Tổng</th>
            <th>Trạng thái</th>
            <th>Thao tác</th>
          </tr>
        </thead>

        <tbody>
          @foreach($orders as $order)
          <tr>

            <td>{{ $loop->iteration }}</td>
            <td>{{$order->order_number}}</td>
            <td>{{$order->first_name}} {{$order->last_name}}</td>
            <td>{{$order->email}}</td>
            <td>{{$order->quantity}}</td>
            <td>{{$order->shipping->price}}đ</td>
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
              <a href="{{route('user.order.show',$order->id)}}" class="btn btn-warning btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="view" data-placement="bottom"><i class="fas fa-eye"></i></a>
              {{-- <form method="POST" action="{{route('user.order.delete',[$order->id])}}">--}}
              {{-- @csrf--}}
              {{-- @method('delete')--}}
              {{-- <button class="btn btn-danger btn-sm dltBtn" data-id={{$order->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>--}}
              {{-- </form>--}}
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
      <span style="float:right">{{$orders->links()}}</span>
      @else
      <h6 class="text-center">Không có đơn hàng nào!!!</h6>
      @endif
    </div>
  </div>
</div>
@endsection

@push('styles')
<link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
<style>
  div.dataTables_wrapper div.dataTables_paginate {
    display: none;
  }
</style>
@endpush

@push('scripts')

<!-- Page level plugins -->
<script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

<!-- Page level custom scripts -->
<script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
<script>
  $('#order-dataTable').DataTable({
    "columnDefs": [{
      "orderable": false,
      "targets": [8]
    }]
  });

  // Sweet alert

  function deleteData(id) {

  }
</script>
<script>
  $(document).ready(function() {
    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('.dltBtn').click(function(e) {
      var form = $(this).closest('form');
      var dataID = $(this).data('id');
      // alert(dataID);
      e.preventDefault();
      swal({
          title: "Bạn có chắc không?",
          text: "Khi xóa sẽ không thể khôi phục dữ liệu!",
          icon: "warning",
          buttons: true,
          dangerMode: true,
        })
        .then((willDelete) => {
          if (willDelete) {
            form.submit();
          } else {
            swal("Dữ liệu an toàn!");
          }
        });
    })
  })
</script>
@endpush