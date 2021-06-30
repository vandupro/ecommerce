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
<div class="col-md-12">
<a href="{{route('admin.role.create')}}" class="btn btn-secondary"><i class="fas fa-plus-circle"> Thêm mới chức vụ</i></a> 
</div>
    <div class="card">
        <!-- /.card-header -->
        <div class="card-body">
            <table id="example2" class="table table-bordered table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Tên chức vụ</th>
                        <th>Mô tả chức vụ</th>
                        <th colspan="2">Hành động</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{$role->name}}</td>
                        <td>{{$role->desc}}</td>

                        <td>
                            <a href="{{route('admin.role.edit',['id'=>$role->id])}}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                            <a href="{{route('admin.role.destroy',['id'=>$role->id])}}" class="btn btn-danger" onclick='return confirm("Bạn có muốn xóa không?")'><i class="fas fa-trash-alt"></i></a>
                        </td>
                    </tr>
                    @endforeach

                </tbody>
                <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Tên chức vụ</th>
                        <th>Mô tả chức vụ</th>
                        <th colspan="2">Hành động</th>

                    </tr>
                </tfoot>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
</div>
@endsection