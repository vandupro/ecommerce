@extends('admin.layout')
@section('title', 'Cập nhật thương hiệu')
@section('content')
<div class="card">
    <div class="card-header">
       <a href="{{ route('admin.branches.index') }}" class="btn btn-primary">Quay lại</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.branches.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" value="{{ $model->id }}">
            <div class="form-group">
                <label for="name">Tên thương hiệu</label>
                <input value="{{ $model->name }}" type="text" id="name" name="name" class="form-control" require>
            </div>
            @error('name')
            <div class="alert alert-danger mt-3" role="alert">
                {{$message}}
            </div>
            @enderror
            <div class="form-group">
                <label for="slug">Slug</label>
                <input value="{{ $model->slug }}" type="text" id="slug" name="slug" class="form-control" require>
            </div>
            @error('slug')
            <div class="alert alert-danger mt-3" role="alert">
                {{$message}}
            </div>
            @enderror
            <div class="form-group">
                <label for="image">Hình ảnh</label>
                <input onchange="previewFile(this)" type="file" id="image" name="image" class="form-control" require>
                <input type="hidden" name="image2" value="{{ $model->image }}">
                <div class="mt-3" style="width: 130px; height: 200px; border: 1px solid gray">
                    <img style="max-width: 130px" src="{{ asset('/storage/images/branches/'. $model->image) }}" id="previewimg" alt="">
                </div>
            </div>
            @error('image')
            <div class="alert alert-danger mt-3" role="alert">
                {{$message}}
            </div>
            @enderror
            <div class="form-group">
                <button class="btn btn-success">Cập nhật</button>
            </div>
        </form>
    </div>
</div>


@endsection
@section('javascript')
<script>
function previewFile(input) {
    var file = $("input[type=file]").get(0).files[0];
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