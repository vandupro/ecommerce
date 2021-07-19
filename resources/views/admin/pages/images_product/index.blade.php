@extends('admin.layout')
@section('title', "Danh sách ảnh sản phẩm")
@section('content')
<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{ route('admin.images.create') }}">Thêm mới</a>
        <div style="display:flex; justify-content:space-around">
            <form action="" method="GET">
                <div style="margin: 15px 0; display:flex">
                    <div style="width: 80%; margin-top:23px" class="ml-3">
                        <input value="{{$param['keyword']}}" placeholder="type here" class="form-control"
                            type="text" name="keyword">
                    </div>
                    <div class="mr-3 ml-3" style="margin-top: 22px">
                        <button class="btn btn-success">Tìm kiếm theo tên sản phẩm</button>
                    </div>
                </div>
            </form>
        </div>


    </div>
    <div class="card-body">
        <table class="table table-scriped" id="categoryTable">
            <thead>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>Hình ảnh</th>
                <th>Giá</th>
                <th>Hành động</th>
            </thead>
            <tbody>
                @foreach($images as $m)
                <tr>
                    <td>{{($images->currentPage-1)*pagesize + $loop->iteration }}</td>
                    <td>{{ $m->product->name }}</td>
                    <td>
                        <img style="width: 50px; height: 50px" src="{{ asset('/storage/images/images_product/'.$m->image) }}"
                            alt="">
                    </td>
                    <td>
                        <a href="{{ route('admin.images.edit', ['id'=>$m->id])}}" class="btn btn-warning">Sửa</a>
                        <a onclick="return confirm('Bạn có chắc xóa không?')"
                            href="{{ route('admin.images.delete', ['id'=>$m->id])}}" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @if(count($models))
    {{$models->links()}}
    @endif
</div>
@endsection
@section('javascript')
@if(Session::has('message'))
<script>
swal({
    title: "Good job!",
    text: "{{ Session::get('message') }}!",
    icon: "success",
    button: "OK!",
});
</script>
@endif

@endsection