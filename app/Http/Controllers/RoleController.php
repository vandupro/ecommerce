<?php

namespace App\Http\Controllers;

use App\Models\Role;
use Illuminate\Http\Request;
use App\Models\Permission;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    private $permission;
    private $role;
    public function __construct(Permission $permission, Role $role)
    {
        $this->permission = $permission;
        $this->role = $role;
    }
    public function index(Request $request)
    {  
        $data = [];
        $request->table_search = isset($request->table_search) == true ? $request->table_search: "";
        $pagenumber = isset($request->page) == true ? $request->page : 1; // 1 / 5 = 0->5   \\\ 2/5= 5->9
        $pagesize = 5; // số lượng bản ghi trong một
        $offset = ($pagenumber - 1) * $pagesize;
       
   
        $roles = $this->role->where('name', 'like', '%' .$request->table_search. '%');

        $data['totalPage'] = intval(ceil(count($roles->get()) / $pagesize));

        $roles =  $roles->take($pagesize)->skip($offset)->get();

        $data["table_search"] = $request->table_search;

      // dd($data['totalPage']);
        return view("admin.pages.roles.index", compact('roles','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions_parent = $this->permission->where('parent_id', 0)->get();
        // dd($permissions_parent);
        return view("admin.pages.roles.add", compact('permissions_parent'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // validator
        $rules = [
            'name' => 'required|max:100|min:4',
            'desc' => 'required|max:200|min:4',
        ];
        $messages = [
            'name.required' => 'Mời chọn tên chức vụ!',
            'desc.required' => 'Mời nhập mô tả chức vụ!',
            'desc.max' => 'Mô tả  không quá 200 ký tự!',
            'desc.min' => 'Mô tả  ít nhất 4 ký tự!',
            'name.max' => 'Chức vụ  không quá 100 ký tự!',
            'name.min' => 'Chức vụ  ít nhất 4 ký tự!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        //dd($request->permission_id);
        try {
            DB::beginTransaction();
            $roles =  $this->role->create([
                'name' => $request->name,
                'desc' => $request->desc
            ]);

            $roles->permissions()->attach($request->permission_id);
            DB::commit();
            return \redirect()->route('admin.role.index')->with('status', 'Thêm mới chức vụ thành công !');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('message :', $exception->getMessage() . '--line :' . $exception->getLine());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $permissions_parent = $this->permission->where('parent_id', 0)->get();
        $roles = $this->role->find($id);

        if (isset($roles) && !empty($roles)) {
            $permissionsChecked = $roles->permissions;
            
            return view("admin.pages.roles.edit", compact('permissions_parent', 'roles', 'permissionsChecked'));
        } else {
            return redirect()->back();
        }
    }


    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:100|min:4',
            'desc' => 'required|max:200|min:4',
        ];
        $messages = [
            'name.required' => 'Mời chọn tên chức vụ!',
            'desc.required' => 'Mời nhập mô tả chức vụ!',
            'desc.max' => 'Mô tả  không quá 200 ký tự!',
            'desc.min' => 'Mô tả  ít nhất 4 ký tự!',
            'name.max' => 'Chức vụ  không quá 100 ký tự!',
            'name.min' => 'Chức vụ  ít nhất 4 ký tự!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        try {
            DB::beginTransaction();
            $this->role->find($id)->update([
                'name' => $request->name,
                'desc' => $request->desc
            ]);
            $roles = $this->role->find($id);
            $roles->permissions()->sync($request->permission_id); // upload update array to role_user ===> 'sync'
            DB::commit();
            return redirect()->back()->with('status', 'Cập nhật chức vụ thành công !');
        } catch (Exception $exception) {
            DB::rollBack();
            Log::error('message :', $exception->getMessage() . '--line :' . $exception->getLine());
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Role $role)
    {
        $this->role->find($id)->delete();
        return redirect()->back()->with('status', 'Bạn xóa chức vụ thành công !');
    }
}
