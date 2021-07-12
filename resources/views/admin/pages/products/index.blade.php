@extends('admin.layout')
@section('title', "Danh sách sản phẩm")
@section('content')
<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{ route('admin.products.create') }}">Thêm mới</a>
    </div>
    <div class="card-body">
        <table class="table table-scriped" id="categoryTable">
            <thead>
                <th>ID</th>
                <th>Tên sản phẩm</th>
                <th>SLug</th>
                <th>Hình ảnh</th>
                <th>Giá</th>
                <th>Giá cạnh tranh</th>
                <th>Hành động</th>
            </thead>
            <tbody>
                @foreach($models as $m)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $m->name }}</td>
                    <td>{{ $m->slug }}</td>
                    <td>
                        <img style="width: 50px; height: 50px" src="{{ asset('/storage/images/products/'.$m->image) }}" alt="">
                    </td>
                    <td>{{ $m->price }}</td>
                    <td>{{ $m->competitive_price }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', ['id'=>$m->id])}}" class="btn btn-warning">Sửa</a>
                        <a onclick="return confirm('Bạn có chắc xóa không?')" href="{{ route('admin.products.delete', ['id'=>$m->id])}}" class="btn btn-danger">Xóa</a>
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