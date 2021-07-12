@extends('admin.layout')
@section('title')
Thêm mới roles
@endsection
@section('content')
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title d-flex "> <a href="{{route('admin.permission.index')}}"><i class="fas fa-undo-alt"></i></a></h3>
    </div>
    <form action="{{route('admin.role.store')}}" method="post">
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputEmail1">Tên chức vụ</label>
                <input type="text" class="form-control" name="name" id="exampleInputEmail1" placeholder="Nhập tên chức vụ">
                <code> {{ $errors->first('name') }} </code>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Mô tả chức vụ</label>

                <textarea name="desc" class="form-control" id="exampleInputEmail1" cols="30" rows="10" placeholder="Mô tả chức vụ"></textarea>
                <code> {{ $errors->first('desc') }} </code>
            </div>

            <div class="card" style="padding-left: 2%;">
                <div class="card-body">
                    <h5>
                        <input class="custom-control-input checkbox_all" type="checkbox" id="customCheckbox1all" value="">
                        <label for="customCheckbox1all" class="custom-control-label">Chọn tất cả</label>
                    </h5>
                </div>
            </div>
            <div class="col-md-12 d-flex">

                @foreach($permissions_parent as $permissions_parents)
                <div class="col-md-3" style="float:left;">
                    <!-- USERS LIST -->
                    <div class="card card1">
                        <div class="card-header bg-success">
                            <h3 class="card-title" style="padding-left: 6%;">
                                <input class="custom-control-input checkbox_wrapper" type="checkbox" id="customCheckbox1{{$permissions_parents->id}}" value="{{$permissions_parents->name}}">
                                <label for="customCheckbox1{{$permissions_parents->id}}" class="custom-control-label">{{$permissions_parents->name}}</label>

                            </h3>
                        </div>
                        <!-- /.card-header -->
                        <div class="card-body p-0" style="height: 290px;">

                            <textarea name="" class="col-md-12" rows="2" disabled>Module {{$permissions_parents->desc}}</textarea>
                            <ul class="users-list clearfix">
                                <table class="table m-0">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Hành động</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($permissions_parents->permissionsChilden as $permissionsChildenItem)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                            <td><input class="custom-control-input checkbox_childen" type="checkbox" name="permission_id[]" id="customCheckbox1{{$permissionsChildenItem->id}}" value="{{$permissionsChildenItem->id}}">
                                                <label for="customCheckbox1{{$permissionsChildenItem->id}}" class="custom-control-label">{{$permissionsChildenItem->name}}</label>
                                            </td>

                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </ul>
                            <!-- /.users-list -->
                        </div>
                        <!-- /.card-body -->
                        <div class="card-footer text-center">


                        </div>
                        <!-- /.card-footer -->
                    </div>

                    <!--/.card -->
                </div>
                @endforeach
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

<script>
    $('.checkbox_wrapper').on('click', function() {
        $(this).parents('.card1').find('.checkbox_childen').prop('checked', $(this).prop('checked'));
    })

    $('.checkbox_all').on('click', function() {
        $(this).parents('').find('input[type="checkbox"]').prop('checked', $(this).prop('checked'));
        // $(this).parents('.card').find('.checkbox_childen').prop('checked', $(this).prop('checked'));
    })
</script>

@endsection