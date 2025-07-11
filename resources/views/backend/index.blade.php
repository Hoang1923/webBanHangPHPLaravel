@extends('backend.layouts.master')
@section('title','Jelly-Boutique || DASHBOARD')
@section('main-content')
<div class="container-fluid">
    @include('backend.layouts.notification')
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
    </div>
<div id="error-message" style="color: red; display: none;"></div>
   <form id="filterForm" action="{{ route('admin.dashboard') }}" method="GET" class="form-inline mb-4">
    <div class="form-group mx-sm-3 mb-2">
        <label  style="padding-right: 20px;" for="from_date" class="">Từ ngày: </label>
        <input type="date" name="from_date" id="from_date" value="{{ request()->from_date }}" class="form-control" placeholder="Từ ngày">
    </div>
    <div class="form-group mx-sm-3 mb-2">
        <label style="padding-right: 20px;" for="to_date" class="">Đến ngày: </label>
        <input type="date" name="to_date" id="to_date" value="{{ request()->to_date }}" class="form-control" placeholder="Đến ngày">
    </div>
    <button type="submit" class="btn btn-primary mb-2">Lọc</button>
</form>




    <!-- Content Row -->
    <div class="row">

      <!-- Category -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Danh mục sản phẩm</div>
                <!-- <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Category::countActiveCategory()}}</div> -->
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $categoryCount ?? 0 }}</div>

              </div>
              <div class="col-auto">
                <i class="fas fa-sitemap fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Products -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Sản phẩm</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $productCount ?? 0 }}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-cubes fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- Order -->
      <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">Đơn hàng</div>
                <div class="row no-gutters align-items-center">
                  <div class="col-auto">
                    <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$orderCount ?? 0}}</div>
                  </div>

                </div>
              </div>
              <div class="col-auto">
                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div>

      <!--Posts-->
      <!-- <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
          <div class="card-body">
            <div class="row no-gutters align-items-center">
              <div class="col mr-2">
                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Bài viết</div>
                <div class="h5 mb-0 font-weight-bold text-gray-800">{{\App\Models\Post::countActivePost()}}</div>
              </div>
              <div class="col-auto">
                <i class="fas fa-folder fa-2x text-gray-300"></i>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!--Đơn hàng đã hủy-->
      <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">Đơn hàng đã hủy</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$cancelOrderCount}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-trash-alt fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>

        <div class="row">

            <!-- Số lượng khách hàng -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">Tài khoản</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$customerCount ?? 0}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-user fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Hàng tồn -->
            <!-- <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Hàng tồn kho</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{$sumProduct}}</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-cubes fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div> -->

            <!-- Đơn hàng chưa duyệt -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">Đơn hàng chưa duyệt</div>
                                <div class="row no-gutters align-items-center">
                                    <div class="col-auto">
                                        <div class="h5 mb-0 mr-3 font-weight-bold text-gray-800">{{$newOrderCount}}</div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tổng doanh thu -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">Tổng doanh thu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{number_format($totalRevenue,0)}}đ</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        

    <div class="row">

      <!-- Area Chart -->
      <div class="col-xl-12 col-lg-7">
        <div class="card shadow mb-4">
          <!-- Card Header - Dropdown -->
          <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Thống kê các giao dịch</h6>

          </div>
          <!-- Card Body -->
          <div class="card-body">
<iframe src="https://public.casso.vn/c06619c5-077e-4b6f-8cd6-6836474c38b2" allowfullscreen="allowfullscreen" style="width: 100%; height: 100vh; border: none;"></iframe>          </div>
        </div>
      </div> 

      <!-- Pie Chart -->
      <!-- <div class="col-xl-4 col-lg-5">
        <div class="card shadow mb-4"> -->
          <!-- Card Header - Dropdown -->
          <!-- <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Tài khoản đăng ký trong 7 ngày gần nhất</h6>
          </div> -->
          <!-- Card Body -->
          <!-- <div class="card-body" style="overflow:hidden">
            <div id="pie_chart" style="width:350px; height:320px;">
          </div>
        </div>
      </div>
    </div> -->
    <!-- Content Row -->

  </div>
@endsection

@push('scripts')
<script>
  document.getElementById('filterForm').addEventListener('submit', function(event) {
    const fromDate = document.getElementById('from_date').value;
    const toDate = document.getElementById('to_date').value;

    if (fromDate && toDate) {
      const from = new Date(fromDate);
      const to = new Date(toDate);

      if (to < from) {
        alert('Đến ngày phải lớn hơn hoặc bằng Từ ngày!');
        event.preventDefault();
      }
    }
  });
</script>

<!-- Các script khác -->
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
@endpush
