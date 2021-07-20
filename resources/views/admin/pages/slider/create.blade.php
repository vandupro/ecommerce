@extends('admin.layout')
@section('title', 'Thêm mới slider')
@section('content')
<div class="card">
    <div class="card-header">
       <a href="{{ route('admin.slider.index') }}" class="btn btn-primary">Quay lại</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.slider.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
 <label for="caption">Tiêu đề slider </label>
            
                <textarea id="caption" name="caption" style="display: none;" class="form-control">{{ old('caption') }}</textarea>
            </div>   @error('caption')
            <div class="alert alert-danger mt-3" role="alert">
                {{$message}}
            </div>
            @enderror
            <div class="form-group">
                <label for="desc">Tiêu đề chi tiết </label>
                <textarea id="desc" name="desc" style="display: none;" class="form-control">{{ old('desc') }}</textarea>
            </div>
            @error('desc')
            <div class="alert alert-danger mt-3" role="alert">
                {{$message}}
            </div>
            @enderror
            <div class="form-group">
                <label for="slug">Sản phẩm liên kết</label>
                <select class="js-example-basic-multiple form-control"value="{{ old('link') }}" name="link">
                   <option value="">chọn sản phẩm liên kết</option>
                @foreach($links as $link)
                <option value="{{$link->slug}}">{{$link->name}}</option>
                @endforeach
               </select>
            </div>
       
           <br>
           <div class="form-group">
            <label for="image">Hình ảnh</label>
            <input onchange="previewFile(this)" type="file" id="image" name="image" class="form-control" require>
            <div class="mt-3" style="width: 100%; height: 100%; border: 1px solid gray">
                <img style="max-width: 100%" id="previewimg" alt="">
            </div>
        </div>
            @error('image')
            <div class="alert alert-danger mt-3" role="alert">
                {{$message}}
            </div>
            @enderror
            <div class="form-group">
                <button class="btn btn-success">Thêm mới</button>
            </div>
        </form>
    </div>
</div>
<style>
    .select2-container--default .select2-selection--single .select2-selection__rendered {
    color: #444;
    line-height: 18px;
}
</style>

@endsection
@section('javascript')

<script>
function previewFile(input) {
    var file = $("#image").get(0).files[0];
    console.log(file);
    if (file) {
        var reader = new FileReader();
        reader.onload = function() {
            $('#previewimg').attr('src', reader.result);
        }
        reader.readAsDataURL(file);
    }
}
$(function() {
    // Summernote
    $('#caption').summernote()
    $('#desc').summernote()
    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
    });
})
$(document).ready(function() {//select2
        $('.js-example-basic-multiple').select2();
    });
    $(function() {
        bsCustomFileInput.init();
    });
</script>
@endsection