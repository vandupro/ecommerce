@extends('admin.layout')
@section('title', 'Cập nhật sản phẩm')
@section('content')
<div class="card">
    <div class="card-header">
        <a href="{{ route('admin.products.index') }}" class="btn btn-primary">Quay lại</a>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.products.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <input type="hidden" value="{{ $model->id }}" name="product_id">
            <div class="form-group">
                <label for="desc">Mô tả</label>
                <textarea id="summernote" name="desc" style="display: none;">{{ $model->desc }}</textarea>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Tên sản phẩm</label>
                        <input value="{{ $model->name }}" type="text" id="name" name="name" class="form-control"
                            require>
                    </div>
                    @error('name')
                    <div class="alert alert-danger mt-3" role="alert">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="slug">Slug</label>
                        <input value="{{ $model->slug }}" type="text" id="slug" name="slug" class="form-control"
                            require>
                    </div>
                    @error('slug')
                    <div class="alert alert-danger mt-3" role="alert">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="branch_id">Thương hiệu</label> <br>
                        <select class="form-control" name="branch_id" id="">
                            @foreach($branches as $b)
                            @if($model->branch_id == $b->id)
                                <option selected value="{{ $b->id }}"> {{ $b->name }} </option>
                            @else
                                <option selected value="{{ $b->id }}"> {{ $b->name }} </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="cate_id">Danh mục</label> <br>
                        @foreach($categories as $c)
                        <input {{ $product_ids->contains('cate_id', $c->id) ? 'checked' : ''}} type="checkbox" 
                            name="cate_id[]" value="{{ $c->id }}"> {{ $c->name }} |
                        @endforeach
                    </div>
                    <div class="form-group">
                        <label for="cate_id">Tag</label> <br>
                        @foreach($tags as $t)
                        <input {{ $tag_ids->contains('tag_id', $t->id) ? 'checked' : ''}} type="checkbox" 
                            name="tag_id[]" value="{{ $t->id }}"> {{ $t->name }} |
                        @endforeach
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="short_desc">Miêu tả ngắn</label>
                        <textarea class="form-control" name="short_desc" id="" cols="30"
                            rows="6">{{ $model->short_desc }}</textarea>
                    </div>
                    @error('short_desc')
                    <div class="alert alert-danger mt-3" role="alert">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="price">Giá</label>
                        <input value="{{ $model->price }}" type="number" id="price" name="price" class="form-control"
                            require>
                    </div>
                    @error('price')
                    <div class="alert alert-danger mt-3" role="alert">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="competitive_price">Giá cạnh tranh</label>
                        <input value="{{ $model->competitive_price }}" type="number" id="competitive_price"
                            name="competitive_price" class="form-control" require>
                    </div>
                    @error('competitive_price')
                    <div class="alert alert-danger mt-3" role="alert">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="discount">Khuyến mại</label>
                        <input value="{{ $model->discount }}" type="number" id="discount" name="discount"
                            class="form-control" require>
                    </div>
                    @error('discount')
                    <div class="alert alert-danger mt-3" role="alert">
                        {{$message}}
                    </div>
                    @enderror
                    <div class="form-group">
                        <label for="image">Hình ảnh</label>
                        <input onchange="previewFile(this)" type="file" id="image_update" name="image" class="form-control"
                            require>
                        <input type="hidden" name="image2" value="{{ $model->image }}">
                        <div class="mt-3" style="width: 130px; height: 200px; border: 1px solid gray">
                            <img style="max-width: 130px" src="{{ asset('/storage/images/products/'. $model->image) }}"
                                id="previewimg" alt="">
                        </div>
                    </div>
                    @error('image')
                    <div class="alert alert-danger mt-3" role="alert">
                        {{$message}}
                    </div>
                    @enderror
                </div>
            </div>
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
    var file = $("#image_update").get(0).files[0];
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
    $('#summernote').summernote()

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
        mode: "htmlmixed",
        theme: "monokai"
    });
})
</script>
@endsection