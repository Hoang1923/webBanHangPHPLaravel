@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <h5 class="card-header">Thêm sản phẩm</h5>
  <div class="card-body">
    <form enctype="multipart/form-data" method="post" action="{{route('product.store')}}">
      {{csrf_field()}}
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{old('title')}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="summary" class="col-form-label">Tóm tắt <span class="text-danger">*</span></label>
        <textarea class="form-control" id="summary" name="summary">{{old('summary')}}</textarea>
        @error('summary')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="description" class="col-form-label">Mô tả</label>
        <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
        @error('description')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>


      <div class="form-group">
        <label for="is_featured">Nổi bật ?</label><br>
        <input type="checkbox" name='is_featured' id='is_featured' value='1' checked> Yes
      </div>
      {{-- {{$categories}} --}}

      <div class="form-group">
        <label for="cat_id">Danh mục sản phẩm <span class="text-danger">*</span></label>
        <select name="cat_id" id="cat_id" class="form-control">
          <option value="">--Lựa chọn danh mục sản phẩm--</option>
          @foreach($categories as $key=>$cat_data)
          <option value='{{$cat_data->id}}'>{{$cat_data->title}}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group d-none" id="child_cat_div">
        <label for="child_cat_id">Danh mục con</label>
        <select name="child_cat_id" id="child_cat_id" class="form-control">
          <option value="">--Lựa chọn danh mục con--</option>
          {{-- @foreach($parent_cats as $key=>$parent_cat)
                  <option value='{{$parent_cat->id}}'>{{$parent_cat->title}}</option>
          @endforeach --}}
        </select>
      </div>

      <div class="form-group">
        <label for="price" class="col-form-label">Đơn giá <span class="text-danger">*</span></label>
        <input id="price" type="number" name="price" placeholder="Nhập giá" value="{{old('price')}}" class="form-control">
        @error('price')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="discount" class="col-form-label">Giảm giá(%)</label>
        <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Nhập phần trăm giảm giá" value="{{old('discount')}}" class="form-control">
        @error('discount')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="country_id">Nước SX</label>
        {{-- {{$countries}} --}}

        <select name="country_id" class="form-control">
          <option value="">--Lựa chọn nước SX--</option>
          @foreach($countries as $country)
          <option value="{{$country->id}}">{{$country->title}}</option>
          @endforeach
        </select>
      </div>

      <!-- <div class="form-group">
          <label for="size">Dung tích</label>
          <select name="size[]" class="form-control selectpicker"  multiple data-live-search="true">
              <option value="">--Lựa chọn dung tích--</option>
              <option value="100ml">100 ml</option>
              <option value="110ml">110 ml</option>
              <option value="125ml">125 ml</option>
              <option value="150ml">150 ml</option>
          </select>
        </div> -->

      <div class="form-group">
        <label for="brand_id">Thương hiệu</label>
        {{-- {{$brands}} --}}

        <select name="brand_id" class="form-control">
          <option value="">--Lựa chọn thương hiệu--</option>
          @foreach($brands as $brand)
          <option value="{{$brand->id}}">{{$brand->title}}</option>
          @endforeach
        </select>
      </div>


      <div class="form-group">
        <label for="expiry_id">Hạn sử dụng</label>
        {{-- {{$expiries}} --}}

        <select name="expiry_id" class="form-control">
          <option value="">--Lựa chọn--</option>
          @foreach($expiries as $expiry)
          <option value="{{$expiry->id}}">{{$expiry->title}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="unit_id">Đơn vị tính</label>
        {{-- {{$expiries}} --}}

        <select name="unit_id" class="form-control">
          <option value="">--Lựa chọn--</option>
          @foreach($units as $unit)
          <option value="{{$unit->id}}">{{$unit->title}}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="condition">Tình trạng</label>
        <select name="condition" class="form-control">
          <option value="">--Lựa chọn tình trạng--</option>
          <option value="default">Default</option>
          <option value="new">New</option>
          <option value="hot">Hot</option>
        </select>
      </div>

      <div class="form-group">
        <label for="stock">Số lượng <span class="text-danger">*</span></label>
        <input id="quantity" type="number" name="stock" min="0" placeholder="Nhập số lượng" value="{{old('stock')}}" class="form-control">
        @error('stock')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <!-- <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary">
                  <i class="fa fa-picture-o"></i> Lựa chọn
                  </a>
              </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{old('photo')}}">
        </div> -->
      <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
        <div class="input-group">
          <input type="file" id="inputPhoto" name="photo" accept="image/*" class="form-control">
        </div>
      </div>

      <div id="holder" style="margin-top:15px;max-height:100px;">

      </div>
      @error('photo')
      <span class="text-danger">{{$message}}</span>
      @enderror
  </div>

  <div class="form-group">
    <label for="year_of_manufacture">Ngày sản xuất</label>
    <input type="date" name="year_of_manufacture" id="year_of_manufacture" class="form-control" value="{{ old('year_of_manufacture') }}">
  </div>


  <div class="form-group">
    <label for="status" class="col-form-label">Trạng thái <span class="text-danger">*</span></label>
    <select name="status" class="form-control">
      <option value="active">Active</option>
      <option value="inactive">Inactive</option>
    </select>
    @error('status')
    <span class="text-danger">{{$message}}</span>
    @enderror
  </div>
  <div class="form-group mb-3">
    <button type="reset" class="btn btn-warning">Làm lại</button>
    <button class="btn btn-success" type="submit">Thêm sản phẩm</button>
  </div>
  </form>
</div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{secure_asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{secure_asset('backend/summernote/summernote.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

<script>
  $('#lfm').filemanager('image');

  $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Viết một đoạn mô tả ngắn.....",
      tabsize: 2,
      height: 100
    });
  });

  $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Viết mô tả chi tiết.....",
      tabsize: 2,
      height: 150
    });
  });
  // $('select').selectpicker();
</script>

<script>
  $('#cat_id').change(function() {
    var cat_id = $(this).val();
    // alert(cat_id);
    if (cat_id != null) {
      // Ajax call
      $.ajax({
        url: "/admin/category/" + cat_id + "/child",
        data: {
          _token: "{{csrf_token()}}",
          id: cat_id
        },
        type: "POST",
        success: function(response) {
          if (typeof(response) != 'object') {
            response = $.parseJSON(response)
          }
          // console.log(response);
          var html_option = "<option value=''>----Select sub category----</option>"
          if (response.status) {
            var data = response.data;
            // alert(data);
            if (response.data) {
              $('#child_cat_div').removeClass('d-none');
              $.each(data, function(id, title) {
                html_option += "<option value='" + id + "'>" + title + "</option>"
              });
            } else {}
          } else {
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);
        }
      });
    } else {}
  })
</script>
@endpush