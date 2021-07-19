@extends('admin.layout')
@section('title', "Danh sách sản phẩm")
@section('content')
<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{ route('admin.products.create') }}">Thêm mới</a>
        <div style="display:flex; justify-content:space-around">
            <form action="" method="GET">
                <div style="margin: 15px 0; display:flex">
                    <div>
                        <strong>Thương hiệu</strong>
                        <select style="width: 200px;" class="form-control" name="branch" id="branch">
                            <option value="">Tất cả</option>
                            @foreach($branches as $branch)
                            <option value="{{ $branch->slug }}"> {{ $branch->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mr-3 ml-3">
                        <strong>Danh mục</strong>
                        <select style="width: 200px;" class="form-control" name="category" id="branch">
                            <option value="">Tất cả</option>
                            @foreach($categories as $category)
                            @if(Session('check')['cate']==$category->slug)
                            <option selected value="{{ $category->slug }}"> {{ $category->name }} </option>
                            @else
                            <option value="{{ $category->slug }}"> {{ $category->name }} </option>
                            @endif
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <strong>Tag</strong>
                        <select style="width: 200px;" class="form-control" name="tag" id="branch">
                            <option value="">Tất cả</option>
                            @foreach($tags as $tag)
                            <option value="{{ $tag->slug }}"> {{ $tag->name }} </option>
                            @endforeach
                        </select>
                    </div>
                    <div style="width: 80%; margin-top:23px" class="ml-3">
                        <input value="{{$param['keyword']}}" placeholder="type here" class="form-control"
                            type="text" name="keyword">

                    </div>
                    <div class="mr-3 ml-3" style="margin-top: 22px">
                        <button class="btn btn-success">Lọc</button>
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
                <th>SLug</th>
                <th>Thương hiệu</th>
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
                    <td>{{ $m->branch->name }}</td>
                    <td>
                        <img style="width: 50px; height: 50px" src="{{ asset('/storage/images/products/'.$m->image) }}"
                            alt="">
                    </td>
                    <td>{{ $m->price }}</td>
                    <td>{{ $m->competitive_price }}</td>
                    <td>
                        <a href="{{ route('admin.products.edit', ['id'=>$m->id])}}" class="btn btn-warning">Sửa</a>
                        <a onclick="return confirm('Bạn có chắc xóa không?')"
                            href="{{ route('admin.products.delete', ['id'=>$m->id])}}" class="btn btn-danger">Xóa</a>
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