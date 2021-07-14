@extends('admin.layout')
@section('title')
Danh sách người dùng
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
    <div class="w-100 ml-3">
        <div name="search_product" class="form-inline">
            <input name="product_name" value="" class="form-control search" style="width: 350px; margin-right: 20px" placeholder="Nhập tên người dùng..." autocomplete="off">
            <select name="product_status" class="form-control select_fillter" style="width: 150px; margin-right: 20px">
                <option value="all">Tất cả</option>
                <option value="1">Đang hoạt động</option>
                <option value="0">Ngừng hoạt động</option>
            </select>
            <div style="padding: 10px 0">
                <div name="search" class="btn btn-success submit_form">Lọc kết quả</div>
            </div>
            <input type="hidden" class="totalPage" name="page">

        </div>
    </div>
    <div class="row mt-4">
        <nav class="w-100">
            <div class="nav nav-tabs" id="product-tab" role="tablist" style="padding-left: 20px;">
                @foreach($roles as $role)
                @if(count($role->Permissions_roles)>=1)
                <a class="nav-item nav-link {{($loop->iteration==1)?'active':''}} " id="role_{{$role->id}}" data-toggle="tab" href="#{{$role->name}}" role="tab" aria-controls="{{$role->name}}" aria-selected="false">{{$role->name}}</a>
                @endif
                @endforeach
            </div>
        </nav>
        <div class="tab-content w-100" id="nav-tabContent" style="padding-left: 1%;">
            <table class="table table-striped">
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
                <tbody id="profile">

                </tbody>
            </table>
        </div>
    </div>

</div>
<nav aria-label="Page navigation example">
    <ul class="pagination">
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('asset_be/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
@foreach($roles as $role)
<script>
    var get_id = 0;
    var totalPage = 0;
    var result = ``;

    Firstly(id = Number("{{$roles[0]->id}}")); // gọi data lần đầu khi người dùng click

    $('#role_{{$role->id}}').on('click', function() {
        var id = Number("{{$role->id}}");
        get_id = id;
        post(get_id, $('.search').val(), $('.select_fillter').val());
    });

    function Firstly(id) {
        get_id = id;
        post(id);
    }

    function post(test, search = "", status = "all", page = 1) {
        let url_role = "{{route('admin.user.ajax')}}" + "?id=" + test + "&search=" + search + "&status=" + status + "&page=" + page;
       // console.log(url_role);
        // alert(url_role);
        $.ajax({

            type: 'get',
            url: url_role,

            success: function(response) {
                 totalPage = 0;
                console.log(response);                
                if (response.length != 0) {
                    totalPage = response[0].paging.totalPage;
                    result = response.map(response => {

                        if (response.status == 1)
                            response.status = `<span class="badge bg-success"><b>Đang hoạt động</b></span>`;
                        else {
                            response.status = `<span class="badge bg-danger"><b>Ngưng hoạt động</b></span>`;
                        }
                        return `
                    
                                <tr>
                                <th scope="row">${response.id}</th>
                                <td><img src="{{ asset("storage") }}/${response.image}" alt=""style="width: 70px; height: 80px" ></td>
                                <td>${response.name}</td>
                                <td>${response.phone_number}</td>
                                <td>${response.email}</td>
                                
                                <td class="d-flex justify-content-between" colspan="2">
                                <div>${response.status}</div>
                                <div class="btn-group dropleft" style="float:right; margin-right: 6%;">
                                    <div   data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="nav-icon fas fa-ellipsis-v"></i>
                                    </div>
                                    <div class="dropdown-menu" style="min-width: 2rem;  left: 104px;" >
                                        <a href="{{route('admin.user.edit')}}?id=${response.id}"  class="dropdown-item" href="#"><i class="fas fa-edit"></i></a>
                                        <a href="{{route('admin.user.destroy')}}?id=${response.id}"  class="dropdown-item"onclick='return confirm("Bạn có muốn xóa không?")' href="#"><i class="fas fa-trash-alt"></i></a>
                                    </div>
                                    </div>

                                                            </td>
                                        </tr>
                            `
                    }).join("");
                } else {
                    result = `<td colspan="6" style="text-align: center;"><b>Không có người dùng</b></td>`;
                }
                var ca = '';
                for (var i = 1; i <= totalPage; i++) {
                    ca += "<li class='page-item'id ='page_" + i + "'><b class='page-link page_link' onclick='myFunction(item=" + i + ")'>" + i + "</b></li>";
                    //    console.log(i);
                }
                if (totalPage > 1) {
                    document.querySelector(".pagination").innerHTML = ca;
                } else {
                    document.querySelector(".pagination").innerHTML = "";
                }

                document.querySelector("#profile").innerHTML = result;
                document.querySelector(".totalPage").value = totalPage;

            }
        });
        return false;
    }
</script>
@endforeach
<script>
    function myFunction(item) {
        post(get_id, $('.search').val(), $('.select_fillter').val(), item);
    };

    $('.submit_form').on('click', function() {
       
        console.log($('.search').val(), $('.select_fillter').val());
        post(get_id, $('.search').val(), $('.select_fillter').val(), page = 1);
    });
</script>

@endsection