@extends('backend.layouts.master')

@section('title','Jelly-Boutique || Banner Create')

@section('main-content')

<div class="card">
  <h5 class="card-header">Thêm Banner</h5>
  <div class="card-body">
    <form enctype="multipart/form-data" method="post" action="{{route('banner.store')}}">
      {{csrf_field()}}
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Enter title" value="{{old('title')}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="inputDesc" class="col-form-label">Mô tả</label>
        <textarea class="form-control" id="description" name="description">{{old('description')}}</textarea>
        @error('description')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>



      <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Ảnh <span class="text-danger">*</span></label>
        <div class="input-group">
          <input type="file" id="inputPhoto" name="photo" accept="image/*" class="form-control">
        </div>
      </div>

      <div id="holder" style="margin-top:15px;max-height:100px;"></div>
      @error('photo')
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
    <button type="reset" class="btn btn-warning">làm lại</button>
    <button class="btn btn-success" type="submit">Thêm Banner</button>
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
      placeholder: "Viết mô tả",
      tabsize: 2,
      height: 150
    });
  });
</script>
@endpush