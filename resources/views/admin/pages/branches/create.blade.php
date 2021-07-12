@extends('admin.layout')
@section('title', 'Thêm mới thương hiệu')
@section('content')
<div class="card">
    <div class="card-header">
       <a href="{{ route('admin.branches.index') }}" class="btn btn-primary">Quay lại</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.branches.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Tên thương hiệu</label>
                <input value="{{ old('name') }}" type="text" id="name" name="name" class="form-control" require>
            </div>
            @error('name')
            <div class="alert alert-danger mt-3" role="alert">
                {{$message}}
            </div>
            @enderror
            <div class="form-group">
                <label for="slug">Slug</label>
                <input value="{{ old('slug') }}" type="text" id="slug" name="slug" class="form-control" require>
            </div>
            @error('slug')
            <div class="alert alert-danger mt-3" role="alert">
                {{$message}}
            </div>
            @enderror
            <div class="form-group">
                <label for="image">Hình ảnh</label>
                <input onchange="previewFile(this)" type="file" id="image" name="image" class="form-control" require>
                <div class="mt-3" style="width: 130px; height: 200px; border: 1px solid gray">
                    <img style="max-width: 130px" id="previewimg" alt="">
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


@endsection
@section('javascript')
<script>
function previewFile(input) {
    var file = $("input[type=file]").get(0).files[0];
    console.log(file);
    if (file) {
        var reader = new FileReader();
        reader.onload = function() {
            $('#previewimg').attr('src', reader.result);
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endsection