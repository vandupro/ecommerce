@extends('admin.layout')
@section('title')
Thêm mới người dùng
@endsection
@section('content')

<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title d-flex "> <a href="{{route('admin.user.index')}}"><i class="fas fa-undo-alt"></i></a></h3>
    </div>
    <form action="{{route('admin.user.store')}}" method="post" enctype="multipart/form-data">
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputEmail1">Tên người dùng</label>
                <input type="text" class="form-control" name="name"value="{{ old('name') }}" id="exampleInputEmail" placeholder="Nhập tên người dùng">
                <code> {{ $errors->first('name') }} </code>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Địa chỉ email</label>
                <input type="email" name="email"value="{{ old('email') }}" class="form-control" id="exampleInputEmail1" placeholder="Nhập địa chỉ email người dùng">
                <code> {{ $errors->first('email') }} </code> @if (session('erros'))<code> {{ session('erros') }} </code>@endif
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Ảnh đại diện</label>
                <div class="input-group">
                    <div class="custom-file d-flex justify-content-between">

                        <div class="col-md-11">
                            <input onchange="previewFile(this)" value="{{ old('image') }}" type="file" class="custom-file-input" name="image" id="product_image">
                            <label class="custom-file-label" for="exampleInputFile">Chọn ảnh </label>
                        </div>
                        <div class="col-md-1">
                       
                            <img style="width: 100px;" id="previewimg" alt="">
                        </div>

                    </div>

                </div>
                <code> {{ $errors->first('image') }} </code>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Số điện thoại</label>
                <input type="tel" id="phone" class="form-control" value="{{ old('phone_number') }}" name="phone_number" placeholder="+ 84">
                <code> {{ $errors->first('phone_number') }} </code>
            </div>
            <div class="form-group">
                <label for="exampleInputPassword1">Mật khẩu</label>
                <input type="password" class="form-control" name="password" value="{{ old('password') }}" id="exampleInputPassword1" placeholder="Nhập mật khẩu">
                <code> {{ $errors->first('password') }} </code>
            </div>

            <div class="form-group">
                <label for="exampleInputEmail1">Chức vụ người dùng</label>
                <select class="js-example-basic-multiple form-control"value="{{ old('role_id[]') }}" name="role_id[]" multiple="multiple">
                    @foreach($roles as $role)
                    <option value="{{$role->id}}">{{$role->name}}</option>
                    @endforeach
                </select>
                <code> {{ $errors->first('profile') }} </code>
            </div>
            <div class="custom-control custom-switch">
                      <input type="checkbox" class="custom-control-input" name="status" id="customSwitch1">
                      <label class="custom-control-label" for="customSwitch1">Kích hoạt tài khoản</label>
                    </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Mô tả người dùng</label>
                <textarea name="profile" class="form-control" id="exampleInputEmail1" cols="30" rows="10" placeholder="Mô tả người dùng">{{ old('profile') }}</textarea>
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

    function previewFile(input) {
    var file = $("#product_image").get(0).files[0];
    console.log(file);
    if (file) {
        var reader = new FileReader();
        reader.onload = function() {
            $('#previewimg').attr('src', reader.result);
        }
        reader.readAsDataURL(file);
        console.log(reader.readAsDataURL(file));
    }
}
    $(document).ready(function() {
        $('.js-example-basic-multiple').select2();
    });
    $(function() {
        bsCustomFileInput.init();
    });
</script>
<!-- <script src="{{asset('asset_be/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script> -->
@endsection