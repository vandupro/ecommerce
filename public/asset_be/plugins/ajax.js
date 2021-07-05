function Firstly(id) {
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