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
    <div class="row mt-4">
        <nav class="w-100">
            <div class="nav nav-tabs" id="product-tab" role="tablist" style="padding-left: 20px;">
                @foreach($roles as $role)
                <a class="nav-item nav-link {{($loop->iteration==1)?'active':''}} " id="role_{{$role->id}}" data-toggle="tab" href="#{{$role->name}}" role="tab" aria-controls="{{$role->name}}" aria-selected="false">{{$role->name}}</a>
                @endforeach
            </div>
        </nav>
        <div class="tab-content w-100" id="nav-tabContent" style="padding-left: 1%;">
            <table class="table table-striped">
                <thead>

                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">Ảnh</th>
                        <th scope="col">Họ và Tên</th>
                        <th scope="col">Số điện thoại</th>
                        <th scope="col">Email</th>
                    </tr>
                </thead>
                <tbody id="profile">
                </tbody>
            </table>

        </div>
    </div>

</div>
@endsection
@section('javascript')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('asset_be/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
@foreach($roles as $role)
<script>
    Firstly(id = Number("{{$roles[0]->id}}"));// gọi data lần đầu khi người dùng click
    $('#role_{{$role->id}}').on('click', function() {
        var id = Number("{{$role->id}}");
        post(id);
    });
    function Firstly(id) {
  
        // alert(id);
        post(id);
    }
    function post(test) {
        let url_role = "{{route('admin.user.ajax')}}" + "?id=" + test;

        // confirm(url_role);

        $.ajax({

            type: 'get',
            url: url_role,

            success: function(response) {
                const result = response.map(response => {
                    return `
                    
                    <tr>
      <th scope="row">${response.id}</th>
      <td><img src="{{ asset("storage") }}/${response.image}" alt=""style="width: 70px; height: 100px" ></td>
      <td>${response.name}</td>
      <td>${response.phone_number}</td>
      <td>${response.email}</td>
      <td>
        <a href="{{route('admin.user.edit')}}?id=${response.id}" class="btn btn-success"><i class="fas fa-edit"></i></a>
        <a href="{{route('admin.user.destroy')}}?id=${response.id}" class="btn btn-danger" onclick='return confirm("Bạn có muốn xóa không?")'><i class="fas fa-trash-alt"></i></a>
                        </td>
      </tr>
                    `
                }).join("");


                if (result == '') {
                    console.log("thanh công")
                }
                document.querySelector("#profile").innerHTML = result;;


            }
        });
        return false;
    }
</script>
@endforeach

@endsection