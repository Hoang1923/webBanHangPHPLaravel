@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <h5 class="card-header">Chỉnh sửa sản phẩm</h5>
  <div class="card-body">
    <form enctype="multipart/form-data" method="post" action="{{route('product.update',$product->id)}}">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{$product->title}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="summary" class="col-form-label">Tóm tắt <span class="text-danger">*</span></label>
        <textarea class="form-control" id="summary" name="summary">{{$product->summary}}</textarea>
        @error('summary')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="description" class="col-form-label">Mô tả</label>
        <textarea class="form-control" id="description" name="description">{{$product->description}}</textarea>
        @error('description')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>


      <div class="form-group">
        <label for="is_featured">Nổi bật ?</label><br>
        <input type="checkbox" name='is_featured' id='is_featured' value='{{$product->is_featured}}' {{(($product->is_featured) ? 'checked' : '')}}> Yes
      </div>
      {{-- {{$categories}} --}}

      <div class="form-group">
        <label for="cat_id">Danh mục sản phẩm <span class="text-danger">*</span></label>
        <select name="cat_id" id="cat_id" class="form-control">
          <option value="">--Lựa chọn danh mục sản phẩm--</option>
          @foreach($categories as $key=>$cat_data)
          <option value='{{$cat_data->id}}' {{(($product->cat_id==$cat_data->id)? 'selected' : '')}}>{{$cat_data->title}}</option>
          @endforeach
        </select>
      </div>
      @php
      $sub_cat_info=DB::table('categories')->select('title')->where('id',$product->child_cat_id)->get();
      // dd($sub_cat_info);

      @endphp
      {{-- {{$product->child_cat_id}} --}}
      <div class="form-group {{(($product->child_cat_id)? '' : 'd-none')}}" id="child_cat_div">
        <label for="child_cat_id">Danh mục con</label>
        <select name="child_cat_id" id="child_cat_id" class="form-control">
          <option value="">--Lựa chọn danh mục con--</option>

        </select>
      </div>

      <div class="form-group">
        <label for="price" class="col-form-label">Giá <span class="text-danger">*</span></label>
        <input id="price" type="number" name="price" placeholder="Enter price" value="{{$product->price}}" class="form-control">
        @error('price')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="discount" class="col-form-label">Giảm giá(%)</label>
        <input id="discount" type="number" name="discount" min="0" max="100" placeholder="Enter discount" value="{{$product->discount}}" class="form-control">
        @error('discount')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="country_id">Nước SX</label>
        <select name="country_id" class="form-control">
          <option value="">--Lựa chọn nước SX--</option>
          @foreach($countries as $country)
          <option value="{{$country->id}}" {{(($product->country_id==$country->id)? 'selected':'')}}>{{$country->title}}</option>
          @endforeach
        </select>
      </div>


      <div class="form-group">
        <label for="expiry_id">Hạn sử dụng</label>
        <select name="expiry_id" class="form-control">
          <option value="">--Lựa chọn --</option>
          @foreach($expiries as $expiry)
          <option value="{{$expiry->id}}" {{(($product->expiry_id==$expiry->id)? 'selected':'')}}>{{$expiry->title}}</option>
          @endforeach
        </select>
      </div>


      <div class="form-group">
        <label for="unit_id">Đơn vị tính</label>
        <select name="unit_id" class="form-control">
          <option value="">--Lựa chọn --</option>
          @foreach($units as $unit)
          <option value="{{$unit->id}}" {{(($product->unit_id==$unit->id)? 'selected':'')}}>{{$unit->title}}</option>
          @endforeach
        </select>
      </div>


      <!-- <div class="form-group">
          <label for="size">Dung tích</label>
          <select name="size[]" class="form-control selectpicker"  multiple data-live-search="true">
              <option value="">--Lựa chọn kích thước--</option>
              @foreach($items as $item)
                @php
                $data=explode(',',$item->size);
                // dd($data);
                @endphp
              <option value="100ml"  @if( in_array( "100ml",$data ) ) selected @endif>100 ml</option>
              <option value="110ml"  @if( in_array( "110ml",$data ) ) selected @endif>110 ml</option>
              <option value="125ml"  @if( in_array( "125ml",$data ) ) selected @endif>125 ml</option>
              <option value="150ml"  @if( in_array( "150ml",$data ) ) selected @endif>150 ml</option>
              @endforeach
          </select>
        </div> -->
      <div class="form-group">
        <label for="brand_id">Thương hiệu</label>
        <select name="brand_id" class="form-control">
          <option value="">--Lựa chọn thương hiệu--</option>
          @foreach($brands as $brand)
          <option value="{{$brand->id}}" {{(($product->brand_id==$brand->id)? 'selected':'')}}>{{$brand->title}}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="condition">Tình trạng</label>
        <select name="condition" class="form-control">
          <option value="">--Lựa chọn tình trạng sản phẩm--</option>
          <option value="default" {{(($product->condition=='default')? 'selected':'')}}>Default</option>
          <option value="new" {{(($product->condition=='new')? 'selected':'')}}>New</option>
          <option value="hot" {{(($product->condition=='hot')? 'selected':'')}}>Hot</option>
        </select>
      </div>

      <div class="form-group">
        <label for="stock">Số lượng <span class="text-danger">*</span></label>
        <input id="quantity" type="number" name="stock" min="0" placeholder="Enter quantity" value="{{$product->stock}}" class="form-control">
        @error('stock')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>
      <!-- <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
          <div class="input-group">
              <span class="input-group-btn">
                  <a id="lfm" data-input="thumbnail" data-preview="holder" class="btn btn-primary text-white">
                  <i class="fas fa-image"></i> Lựa chọn
                  </a>
              </span>
          <input id="thumbnail" class="form-control" type="text" name="photo" value="{{$product->photo}}">
        </div> -->
      <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
        <div class="input-group">
          <input type="file" id="inputPhoto" name="photo" accept="image/*" class="form-control">
        </div>
      </div>
      @if($product->photo)
    <div class="mt-2">
        <img src="{{ asset($product->photo) }}" alt="Ảnh hiện tại" style="max-height: 150px;">
    </div>
@endif
      <div id="holder" style="margin-top:15px;max-height:100px;"></div>
      @error('photo')
      <span class="text-danger">{{$message}}</span>
      @enderror
  </div>
   <div class="form-group">
    <label for="year_of_manufacture">Ngày sản xuất</label>
    <input type="date" name="year_of_manufacture" id="year_of_manufacture" class="form-control" value="{{ old('year_of_manufacture', $product->year_of_manufacture)}}">
  </div>

  <div class="form-group">
    <label for="status" class="col-form-label">Trạng thái <span class="text-danger">*</span></label>
    <select name="status" class="form-control">
      <option value="active" {{(($product->status=='active')? 'selected' : '')}}>Active</option>
      <option value="inactive" {{(($product->status=='inactive')? 'selected' : '')}}>Inactive</option>
    </select>
    @error('status')
    <span class="text-danger">{{$message}}</span>
    @enderror
  </div>
  <div class="form-group mb-3">
    <button class="btn btn-success" type="submit">Cập nhật</button>
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
      height: 150
    });
  });
  $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Write detail Description.....",
      tabsize: 2,
      height: 150
    });
  });
</script>

<script>
  var child_cat_id = '{{$product->child_cat_id}}';
  // alert(child_cat_id);
  $('#cat_id').change(function() {
    var cat_id = $(this).val();

    if (cat_id != null) {
      // ajax call
      $.ajax({
        url: "/admin/category/" + cat_id + "/child",
        type: "POST",
        data: {
          _token: "{{csrf_token()}}"
        },
        success: function(response) {
          if (typeof(response) != 'object') {
            response = $.parseJSON(response);
          }
          var html_option = "<option value=''>--Select any one--</option>";
          if (response.status) {
            var data = response.data;
            if (response.data) {
              $('#child_cat_div').removeClass('d-none');
              $.each(data, function(id, title) {
                html_option += "<option value='" + id + "' " + (child_cat_id == id ? 'selected ' : '') + ">" + title + "</option>";
              });
            } else {
              console.log('no response data');
            }
          } else {
            $('#child_cat_div').addClass('d-none');
          }
          $('#child_cat_id').html(html_option);

        }
      });
    } else {

    }

  });
  if (child_cat_id != null) {
    $('#cat_id').change();
  }
</script>
@endpush