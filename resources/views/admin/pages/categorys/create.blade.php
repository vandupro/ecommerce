@extends('admin.layout')
@section('title')
Thêm mới sản phẩm
@endsection
@section('content')
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title d-flex "> <a href="{{route('admin.cate.index')}}"><i class="fas fa-undo-alt"></i></a></h3>
    </div>
    <form action="{{route('admin.cate.store')}}" method="post">
        @csrf
        <div class="card-body">
            <div class="form-group">
                <label for="exampleInputEmail1">Tên danh mục</label>
                <input type="text" name="name" class="form-control" id="exampleInputEmail1"
                    placeholder="Nhập tên danh mục">
                <code> {{ $errors->first('name') }} </code>
            </div>
            <div class="form-group">
                <label for="exampleInput">Slug</label>
                <input type="text" name="slug" class="form-control" id="exampleInput" placeholder="Nhập slug">
                <code> {{ $errors->first('slug') }} </code>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Giửi</button>
        </div>
    </form>
</div>
@endsection
@section('javascript')



@endsection