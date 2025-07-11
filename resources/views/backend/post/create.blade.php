@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <h5 class="card-header">Thêm bài viết</h5>
  <div class="card-body">
    <form method="post" action="{{route('post.store')}}" enctype="multipart/form-data">
      {{csrf_field()}}
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Tiêu đề <span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="title" placeholder="Nhập tiêu đề" value="{{old('title')}}" class="form-control">
        @error('title')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="quote" class="col-form-label">Trích dẫn</label>
        <textarea class="form-control" id="quote" name="quote">{{old('quote')}}</textarea>
        @error('quote')
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
        <label for="post_cat_id">Danh mục <span class="text-danger">*</span></label>
        <select name="post_cat_id" class="form-control">
          <option value="">--Lựa chọn danh mục bài viết--</option>
          @foreach($categories as $key=>$data)
          <option value='{{$data->id}}'>{{$data->title}}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="tags">Thẻ</label>
        <select name="tags[]" multiple data-live-search="true" class="form-control selectpicker">
          <option value="">--Lựa chọn thẻ--</option>
          @foreach($tags as $key=>$data)
          <option value='{{$data->title}}'>{{$data->title}}</option>
          @endforeach
        </select>
      </div>
      <div class="form-group">
        <label for="added_by">Tác giả</label>
        <select name="added_by" class="form-control" readonly>
          @foreach($users as $user)
          @if (strtolower($user->name) == 'admin')
          <option value="{{ $user->id }}" selected>{{ $user->name }}</option>
          @endif
          @endforeach
        </select>
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
    <button type="reset" class="btn btn-warning">Làm lại</button>
    <button class="btn btn-success" type="submit">Thêm bài viết</button>
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

  $(document).ready(function() {
    $('#quote').summernote({
      placeholder: "Viết trích dẫn.....",
      tabsize: 2,
      height: 100
    });
  });
  // $('select').selectpicker();
</script>
@endpush