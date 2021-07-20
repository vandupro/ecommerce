@extends('admin.layout')
@section('title')
Danh sách người dùng
@endsection
@section('content')



<div class="card card-primary">
    <div class="w-100 ml-3">
        <form name="fillter_user" method="get" action="{{ htmlspecialchars($_SERVER["REQUEST_URI"]) }}" class="form-inline">
            <input name="name" value="{{isset($_GET['name'])?$_GET['name']:''}}" class="form-control search" style="width: 350px; margin-right: 20px" placeholder="Nhập tên người dùng..." autocomplete="off">
            <select name="status" class="form-control select_fillter" style="width: 200px; margin-right: 20px">
                <option value="all" {{isset($_GET['status']) && $_GET['status']=='all'? 'selected':''}}>Tất cả</option>
                <option value="1" {{isset($_GET['status']) && $_GET['status']=='1'? 'selected':''}}>Đang hoạt động</option>
                <option value="0" {{isset($_GET['status']) && $_GET['status']=='0'? 'selected':''}}>Ngừng hoạt động</option>
            </select>
            <select name="roles_id" class="form-control select_fillter" style="width: 200px; margin-right: 20px">
                @foreach($roles as $role)

                <option value="{{$role->id}}" {{isset($_GET['roles_id']) && $_GET['roles_id']== $role->id? 'selected':''}}>{{$role->name}}</option>
                @endforeach
            </select>
            <div style="padding: 10px 0">
                <!-- <button type="submit"  class="btn btn-success ">Lọc kết quả</button> -->
                <input type="submit" class="btn btn-success" value="Lọc kết quả">
            </div>
            <input type="hidden" class="totalPage" name="page" value="{{isset($_GET['page'])?$_GET['page']:1}}">

        </form>
    </div>
    <table class="table table-striped w-100 pl-3" style="text-align: center;">
        <thead>
            <tr>
                <th scope="col">ID </th>
                <th scope="col">Ảnh</th>
                <th scope="col">Họ và Tên</th>
                <th scope="col">Số điện thoại</th>
                <th scope="col">Email</th>
                <th scope="col">Trạng thái</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <th scope="row">{{$user->id}}</th>
                <td> <img src="{{ asset("storage/$user->image") }}" alt="" style="width: 70px; height: 80px"></td>
                <td>{{$user->name}}</td>
                <td>{{$user->phone_number}}</td>
                <td>{{$user->email}}</td>
                <td class="d-flex justify-content-between" colspan="2">
                    <div>
                        <span class="badge {{($user->status)==1?'bg-success':'bg-danger'}} ">
                            <b>{{($user->status)==1?'Đang hoạt động':'Ngưng hoạt động'}}</b>
                        </span>
                    </div>
                    <div class="btn-group dropleft" style="float:right; margin-right: 6%;">
                        <div data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="nav-icon fas fa-ellipsis-v"></i>
                        </div>
                        <div class="dropdown-menu" style="min-width: 2rem;  left: 104px;">
                            <a href="{{route('admin.user.edit',['id'=>$user->id])}}?" class="dropdown-item" href="#"><i class="fas fa-edit"></i></a>
                            <a href="{{route('admin.user.destroy',['id'=>$user->id])}}" class="dropdown-item" onclick='return confirm("Bạn có muốn xóa không?")' href="#"><i class="fas fa-trash-alt"></i></a>
                        </div>
                    </div>

                </td>
            </tr>
            @endforeach
            @if(count($users)<=0)
             <tr>
                <td colspan="7" style="text-align: center;">
                <h3> Không có người dùng nào </h3>
                </td>
            </tr>

                @endif
        </tbody>
    </table>

</div>
<nav aria-label="Page navigation example">
    <ul class="pagination">
        @if($data["totalPage"]>1)
        @for($i=1;$i<=$data["totalPage"];$i++) <li class="page-item"><a class="page-link" href="#">{{$i}}</a></li>
            @endfor
            @endif
    </ul>
</nav>

<style>
    .table td,
    .table th {
        padding: 0;
        vertical-align: top;
        border-top: 1px solid #dee2e6;
        line-height: 80px;
    }
</style>
@endsection

@section('javascript')
@if(Session::has('status'))
<script>
swal({
    title: "Good job!",
    text: "{{ Session::get('status') }}!",
    icon: "success",
    button: "OK!",
});
</script>
@endif
<script>
    $(document).ready(function() {
        $(".page-link").on("click", function(e) {
            e.preventDefault();
            var rel = $(this).text();
            var page = parseInt(rel);

            $("input[name='page']").val(page);

            $("form[name='fillter_user']").trigger("submit");
        });
    });
</script>
<!-- DataTables  & Plugins -->

@endsection