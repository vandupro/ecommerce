@extends('admin.layout')
@section('title', "Thương hiệu sản phẩm")
@section('content')
<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="{{ route('admin.slider.create') }}">Thêm mới</a>
    </div>
    <div class="card-body">
        <table class="table table-scriped">
            <thead>
                <th>ID</th>
                <th>Tiêu đề</th>
                <th>Hình ảnh</th>
                <th>Hành động</th>
            </thead>
            <tbody>
                @foreach($sliders as $c)
                <tr>
                    <td>{{ $c->id  }}</td>
                    <td><?php echo $c->caption ?></td>
                    <td>
                        <img style="width: 200px; height: 100px" src="{{ asset("storage/".$c->image) }}" alt="">
                    </td>

                    <td>
                        <a href="{{ route('admin.slider.edit', ['id'=>$c->id]) }}" class="btn btn-warning">Sửa</a>
                        <a onclick="deleteCategory({{$c->id}})" href="javascript:void(0)" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
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
    function deleteCategory(id) {
    swal({
            title: "Bạn có chắc xóa không?",
            text: "Khi xóa, bạn sẽ không phục hổi lại được!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => {
            if (willDelete) {
                $.get("/admin/slider/destroy/" + id, function(data) {
                    console.log(data);
                    $('#cid' + data.id).css('display', 'none');
                    swal("Great Job", "Xóa danh mục thành công", "success", {
                        button: "OK",
                    })
                });
                swal("Bạn đã xóa danh mục thành công!", {
                    icon: "success",
                });
                location.reload();
            } else {
                swal("Bạn đã hủy xóa danh mục!");
            }
        });
}
</script>
@endsection