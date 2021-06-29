@extends('admin.layout')
@section('title')
Thêm mới permission
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
    <form action="{{route('admin.permission.update',['id'=>$permissions_id->id])}}" method="post">
        @csrf
        <div class="card-body">

            <div class="form-group">
                <label for="exampleInputEmail1">Tên module</label>
                <select class="custom-select" name="module_parent">
                         
                          @foreach(config('permissions.permission_parent') as $module)
                          <option value="{{$module}}"{{$permissions_id->name == $module ? 'selected' : ""}} >{{$module}}</option>
                          @endforeach
                        </select>
                <code> {{ $errors->first('module_parent') }} </code>
            </div>
            <div class="form-group">
                <label for="exampleInputEmail1">Mô tả module</label>
            
                <textarea name="desc" class="form-control" id="exampleInputEmail1" cols="30" rows="10"  placeholder="Mô tả module">{{$permissions_id->desc}}</textarea>
                <code> {{ $errors->first('desc') }} </code>
            </div>
            <div class="col-md-12 d-flex">
                @foreach(config('permissions.permission_childen') as $moduleItem)
                <div class="custom-control custom-checkbox col-md-3">
                    <input class="custom-control-input" type="checkbox" name="module_childent[]"{{$permissionsChecked->contains('name',$moduleItem)? 'checked': ''}} id="customCheckbox1{{$moduleItem}}" value="{{$moduleItem}}">
                    <label for="customCheckbox1{{$moduleItem}}" class="custom-control-label">{{$moduleItem}}</label>
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



@endsection