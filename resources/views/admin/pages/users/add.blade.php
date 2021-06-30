@extends('admin.layout')
@section('title')
Thêm mới người dùng
@endsection
@section('content')
@if (session('status'))
<div class="alert alert-success">
    {{ session('status') }}
</div>
@endif<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title d-flex "> <a href="{{route('admin.user.index')}}"><i class="fas fa-undo-alt"></i></a></h3>
    </div>
    <form action="{{route('admin.user.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputEmail1">Tên người dùng</label>
                <input type="text" class="form-control" name="name" id="exampleInputEmail" placeholder="Nhập tên người dùng">
                <code> {{ $errors->first('name') }} </code>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Địa chỉ email</label>
                <input type="email" name="email" class="form-control" id="exampleInputEmail1" placeholder="Nhập địa chỉ email người dùng">
                <code> {{ $errors->first('email') }} </code> @if (session('erros'))<code> {{ session('erros') }} </code>@endif
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Ảnh đại diện</label>
                <div class="input-group">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" name="image" id="exampleInputFile">
                        <label class="custom-file-label" for="exampleInputFile">Chọn ảnh </label>
                    </div>
                </div>
                <code> {{ $errors->first('image') }} </code>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Số điện thoại</label>
                <input type="tel" id="phone" class="form-control" name="phone_number" placeholder="+ 84">
                <code> {{ $errors->first('phone_number') }} </code>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Mật khẩu</label>
                <input type="password" class="form-control" name="password" id="exampleInputPassword1" placeholder="Nhập mật khẩu">
                <code> {{ $errors->first('password') }} </code>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Chức vụ người dùng</label>
                <select class="js-example-basic-multiple form-control" name="role_id[]" multiple="multiple">
                    @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
                <code> {{ $errors->first('profile') }} </code>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Mô tả người dùng</label>
                <textarea name="profile" class="form-control" id="exampleInputEmail1" cols="30" rows="10" placeholder="Mô tả người dùng"></textarea>
                <code> {{ $errors->first('profile') }} </code>
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
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="{{asset('asset_be/plugins/bs-custom-file-input/bs-custom-file-input.min.js')}}"></script>
<script>
    $(document).ready(function() {
    $('.js-example-basic-multiple').select2();
});
    $(function() {
        bsCustomFileInput.init();
    });
</script>
<!-- <script src="{{asset('asset_be/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script> -->
@endsection