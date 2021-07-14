@extends('admin.layout')
@section('title', 'Danh mục sản phẩm')
@section('content')
<div class="card">
    <div class="card-header">
        <a class="btn btn-primary" href="#" data-toggle="modal" data-target="#categoryModal">Thêm mới</a>
    </div>
    <div class="card-body">
        <table class="table table-scriped" id="categoryTable">
            <thead>
                <!-- <th>ID</th> -->
                <th>Tên danh mục</th>
                <th>SLug</th>
                <th>Hành động</th>
            </thead>
            <tbody>
                @foreach($models as $c)
                <tr id="cid{{$c->id}}">
                    <!-- <td>{{ $loop->iteration }}</td> -->
                    <td>{{ $c->name }}</td>
                    <td>{{ $c->slug }}</td>
                    <td>
                    <a href="javascript:void(0)" onclick="editCategory({{$c->id}})" class="btn btn-warning">Sửa</a>
                        <a href="javascript:void(0)" onclick="deleteCategory({{$c->id}})" class="btn btn-danger">Xóa</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Modal -->
@include('admin.pages.categories.create')
@include('admin.pages.categories.edit')
@endsection
@section('javascript')
<script>
// create category
$('.modal-footer button').on('click', function() {
    $('#cate_alert').css('display', 'none');
    $('#slug_alert').css('display', 'none');

    $('#cate_alert2').css('display', 'none');
    $('#slug_alert2').css('display', 'none');
});
$('#categoryForm').on('submit', function(e) {
    e.preventDefault();
    let cate_name = $('#cate_name').val();
    let slug = $('#slug').val();
    let _token = $('input[name=_token]').val();

    $.ajax({
        url: "{{ route('admin.categories.store') }}",
        type: "POST",
        data: {
            name: cate_name,
            slug: slug,
            _token: _token,
        },
        success: function(response) {
            let id = response.id;
            let edit_html =
                '<a href="javascript:void(0)" onclick="editCategory('+id+')" class="btn btn-warning">Sửa</a>';
            let delete_html =
                '<a href="javascript:void(0)" onclick="deleteCategory('+id+')" class="btn btn-danger">Xóa</a>'
            $('#categoryTable tbody')
                .prepend("<tr id="+"cid"+id+"><td>" + response.name + "</td><td>" + response.slug + "</td><td>" +
                    edit_html + delete_html + "</td></tr>");
            $('#categoryForm')[0].reset();
            $('#categoryModal').modal('hide');

            swal("Great Job", "Thêm danh mục thành công", "success", {
                button: "OK",
            })
        },
        error: function(data) {
            var errors = data.responseJSON;
            if (errors.errors.name) {
                $('#cate_alert').css('display', 'block');
                $('#cate_alert').text(errors.errors.name[0]);
            } else {
                $('#cate_alert').css('display', 'none');
            }
            if (errors.errors.slug) {
                $('#slug_alert').css('display', 'block');
                $('#slug_alert').text(errors.errors.slug[0]);
            } else {
                $('#slug_alert').css('display', 'none');
            }

        }
    });

})

// edit category
function editCategory(id) {
    $.get("/admin/categories/edit/" + id, function(data) {
        $('#id').val(data.id);
        $('#cate_name2').val(data.name);
        $('#slug2').val(data.slug);
        $('#categoryEditModal').modal('toggle');
    })
}
$('#categoryEditModal').on('submit', function(e) {
    e.preventDefault();
    let id = $('#id').val();
    let name = $('#cate_name2').val();
    let slug = $('#slug2').val();
    let _token = $('input[name=_token]').val();

    $.ajax({
        url: "{{ route('admin.categories.update') }}",
        type: "POST",
        data: {
            id: id,
            name: name,
            slug: slug,
            _token: _token,
        },
        success: function(response) {
            $('#cid' + response.id + ' td:nth-child(1)').text(response.name);
            $('#cid' + response.id + ' td:nth-child(2)').text(response.slug);
            $('#categoryEditModal').modal('toggle');
            $('#categoryEditForm')[0].reset();

            swal("Great Job", "Cập nhật danh mục thành công", "success", {
                button: "OK",
            })
        },
        error: function(data) {
            var errors = data.responseJSON;
            if (errors.errors.name) {
                $('#cate_alert2').css('display', 'block');
                $('#cate_alert2').text(errors.errors.name[0]);
            } else {
                $('#cate_alert2').css('display', 'none');
            }
            if (errors.errors.slug) {
                $('#slug_alert2').css('display', 'block');
                $('#slug_alert2').text(errors.errors.slug[0]);
            } else {
                $('#slug_alert2').css('display', 'none');
            }

        }
    });
})

// delete category
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
                $.get("/admin/categories/delete/" + id, function(data) {
                    console.log(data);
                    $('#cid' + data.id).css('display', 'none');
                    swal("Great Job", "Xóa danh mục thành công", "success", {
                        button: "OK",
                    })
                });
                swal("Bạn đã xóa danh mục thành công!", {
                    icon: "success",
                });
            } else {
                swal("Bạn đã hủy xóa danh mục!");
            }
        });
}
</script>
@endsection