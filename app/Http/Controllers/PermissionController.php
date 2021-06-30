<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permissions_parent = Permission::where('parent_id', 0)->get();
        // dd($permissions_parent);
        return view('admin.pages.permission.index', compact('permissions_parent'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.permission.create');
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
        // validator
        $rules = [
            'module_parent' => 'required',
            'desc' => 'required|max:200|min:4',
        ];
        $messages = [
            'module_parent.required' => 'Mời chọn tên module!',
            'desc.required' => 'Mời nhập mô tả module!',
            'desc.max' => 'desc không quá 200 ký tự!',
            'desc.min' => 'desc ít nhất 4 ký tự!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $permission = Permission::create([
            'name' => $request->module_parent,
            'desc' => $request->desc,
            'parent_id' => 0,
            'key_code' => ''
        ]);
        foreach ($request->module_childent as $value_module) {
            Permission::create([
                'name' => $value_module,
                'desc' => $value_module,
                'parent_id' => $permission->id,
                'key_code' => $request->module_parent . '_' . $value_module,

            ]);
        }
        return \redirect()->route('admin.permission.index')->with('status', 'Thêm mới permission thành công !');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function show(Permission $permission)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Permission $permission)
    {
        $permissions_id = $permission->find($id);
        $permissionsChecked = $permissions_id->permissionsChilden;
        //    $selec= Permission::where('parent_id',0)->get();
        //     dd($selec);
        return view('admin.pages.permission.edit', compact('permissions_id', 'permissionsChecked'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function update($id, Request $request, Permission $permission)
    {
        // validator
        $rules = [
            'module_parent' => 'required',
            'desc' => 'required|max:200|min:4',
        ];
        $messages = [
            'module_parent.required' => 'Mời chọn tên module!',
            'desc.required' => 'Mời nhập mô tả module!',
            'desc.max' => 'Mô tả không quá 200 ký tự!',
            'desc.min' => 'Mô tả ít nhất 4 ký tự!',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $permission = $permission->find($id)->update([
            'name' => $request->module_parent,
            'desc' => $request->desc,
            'parent_id' => 0,
            'key_code' => ''
        ]);
        // dd($permissions);
        Permission::where('parent_id', $id)->delete();
        // $name=$request->module_childent;
        foreach ($request->module_childent as $value_module) {
            Permission::create([
                'name' => $value_module,
                'desc' => $value_module,
                'parent_id' => $id,
                'key_code' => $request->module_parent . '_' . $value_module,

            ]);
        }
        return \redirect()->route('admin.permission.index')->with('status', 'Cập nhật permission thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Permission  $permission
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Permission $permission)
    {
        Permission::where('id', $id)->delete();
        Permission::where('parent_id', $id)->delete();
        return redirect()->back()->with('status', 'Xóa thành công permission thành công !');
    }
}
