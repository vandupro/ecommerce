@extends('admin.layout')
@section('title', "Thương hiệu sản phẩm")
@section('content')
<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{ route('admin.branches.create') }}">Thêm mới</a>
    </div>
    <div class="card-body">
        <table class="table table-scriped">
            <thead>
                <th>ID</th>
                <th>Tên thương hiệu</th>
                <th>SLug</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </thead>
            <tbody>
                @foreach($models as $c)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $c->name  }}</td>
                    <td>{{ $c->slug }}</td>
                    <td>
                        <img style="width: 50px; height: 50px" src="{{ asset('/storage/images/branches/' . $c->image) }}" alt="">
                    </td>
                    <td>
                        <a href="{{ route('admin.branches.edit', ['id'=>$c->id]) }}" class="btn btn-warning">Sửa</a>
                        <a onclick="return confirm('Bạn có chắc xóa không?')" href=" {{ route('admin.branches.delete', ['id'=>$c->id]) }}" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
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