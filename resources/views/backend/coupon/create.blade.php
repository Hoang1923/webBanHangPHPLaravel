@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Thêm mã giảm giá</h5>
    <div class="card-body">
      <form method="post" action="{{route('coupon.store')}}">
        {{csrf_field()}}
        <div class="form-group">
        <label for="inputTitle" class="col-form-label">Mã giảm giá <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="code" placeholder="Nhập mã giảm giá"  value="{{old('code')}}" class="form-control">
        @error('code')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="type" class="col-form-label">Kiểu <span class="text-danger">*</span></label>
            <select name="type" class="form-control">
                <option value="fixed">Fixed</option>
                <option value="percent">Percent</option>
            </select>
            @error('type')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="inputTitle" class="col-form-label">Giá trị <span class="text-danger">*</span></label>
            <input id="inputTitle" type="number" name="value" placeholder="Nhập giá trị mã giảm giá"  value="{{old('value')}}" class="form-control">
            @error('value')
            <span class="text-danger">{{$message}}</span>
            @enderror
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
           <button class="btn btn-success" type="submit">Thêm mã giảm giá</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{secure_asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{secure_asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#description').summernote({
      placeholder: "Viết một đoạn mô tả ngắn.....",
        tabsize: 2,
        height: 150
    });
    });
</script>
@endpush
