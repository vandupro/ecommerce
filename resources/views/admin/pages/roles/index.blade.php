@extends('admin.layout')
@section('title')
Danh mục chức vụ
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


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><a href="{{route('admin.role.create')}}" class="btn btn-secondary"><i class="fas fa-plus-circle"> Thêm mới chức vụ</i></a></h3>

                <div class="card-tools">
                   
                        <form name="search_category" class="input-group input-group-sm" action="{{route('admin.role.index')}}"  style="width: 200px;">
                            <input type="text" name="table_search" value="{{$data['table_search']}}"  class="form-control float-right" placeholder="Tìm kiếm chức vụ ...">
                            <input type="hidden" name="page" value="1">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>

                        </form>

                    
                </div>
            </div>
            <!-- /.card-header -->
            <div class="card-body table-responsive p-0" style="height: 450px;">
                <table class="table table-head-fixed text-nowrap">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Tên chức vụ</th>
                            <th>Mô tả chức vụ</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($roles as $role)
                        <tr>
                            <td>{{$role->id}}</td>
                            <td>{{$role->name}}</td>
                            <td colspan="2">
                                <div class="d-flex justify-content-between">
                                    <div>{{$role->desc}}</div>
                                    <div class="btn-group dropleft" style="float:right; margin-right: 6%;">
                                        <div data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="nav-icon fas fa-ellipsis-v"></i>
                                        </div>
                                        <div class="dropdown-menu" style="min-width: 2rem;  left: 104px;">
                                            <a href="{{route('admin.role.edit',['id'=>$role->id])}}" class="dropdown-item" href="#"><i class="fas fa-edit"></i></a>
                                            <a href="{{route('admin.role.destroy',['id'=>$role->id])}}" class="dropdown-item" onclick='return confirm("Bạn có muốn xóa không?")' href="#"><i class="fas fa-trash-alt"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <!-- <td>
                            <a href="{{route('admin.role.edit',['id'=>$role->id])}}" class="btn btn-success"><i class="fas fa-edit"></i></a>
                            <a href="{{route('admin.role.destroy',['id'=>$role->id])}}" class="btn btn-danger" onclick='return confirm("Bạn có muốn xóa không?")'><i class="fas fa-trash-alt"></i></a>
                        </td> -->
                        </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <ul class="pagination pagination-sm m-0 float-right">
                  @for($i=1;$i<=$data["totalPage"];$i++)
                  <li class="page-item"><p class="page-link" >{{$i}}</p></li>
                  @endfor
                </ul>
              </div>
        </div>
        <!-- /.card -->
    </div>
</div>
<style>

</style>
@endsection

@section('javascript')

    <script type="text/javascript">

        $(document).ready(function () {
            $("#clear-search").on("click", function (e) {
                e.preventDefault();

                $("input[name='name']").val('');
                $("select[name='sort']").val('');

                $("form[name='search_category']").trigger("submit");
            });

            $(".page-link").on("click", function (e) {
                e.preventDefault();

                var page = $(this).text();
                page = parseInt(page);
                console.log(page);
                $("input[name='page']").val(page);

                $("form[name='search_category']").trigger("submit");
            });
        });
    </script>

@endsection
