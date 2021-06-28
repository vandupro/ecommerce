@extends('admin.layout')
@section('title')
Danh mục sản phẩm
@endsection
@section('content')
@if (session('status'))
     

        
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong> {{ session('status') }}</strong>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close" style="color:black; opacity: 01;">
        <span aria-hidden="true" style="color:black">&times;</span>
    </button>
</div>
@endif
<div class="card card-primary">
    <div class="card-header">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <form action="simple-results.html">
                            <div class="input-group">

                                <input type="search" class="form-control form-control-lg" placeholder="Tìm kiếm danh mục sản phẩm">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-lg btn-default">
                                        <i class="fa fa-search"></i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên danh mục</th>
                        <th>Slug</th>
                        <th>Số lượng sản phẩm</th>
                        <th colspan="2">Hành động</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($categorys as $category)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td>{{count($category->product)}}</td>
                        <td>
                            <a href="{{route('admin.cate.edit',['id'=>$category->id])}}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                            <a href="{{route('admin.cate.destroy',['id'=>$category->id])}}" class="btn btn-danger" onclick='return confirm("Bạn có muốn xóa không?")'><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Tên danh mục</th>
                        <th>Slug</th>
                        <th>Hành động</th>

                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>
@endsection