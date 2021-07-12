<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Branch::all();

        return view('admin.pages.branches.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.branches.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:branches',
            'slug'=>'required|unique:branches',
            'image'=>'required'
        ]);

        if($request->hasFile('image')){
            $destinationPath = 'public/images/branches';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $path = $request->file('image')->storeAs($destinationPath, $image_name);
            $request->image = $image_name;
        }
        $model = new Branch();
        $model->name = $request->name;
        $model->slug = $request->slug;
        $model->image = $request->image;
        $model->save();
        $request->session()->flash('message', 'Thêm thương hiệu thành công');
        return redirect('/admin/branches');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function show(Branch $branch)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $model = Branch::find($id);
        if($model){
            return view('admin.pages/branches.edit', compact('model'));
        }else{
            return redirect('/admin/branch');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'slug'=>'required',
        ]);
        $image = '';
        $model = Branch::find($request->id);
        if($request->hasFile('image')){
            $destinationPath = 'public/images/branches';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $request->file('image')->storeAs($destinationPath, $image_name);
            $image = $image_name;
            if(file_exists('storage/images/branches/'.$model->image)){
                unlink('storage/images/branches/'.$model->image);
            }
        } else {
            $image = $request->input('image2');
        }
        if($model){
            $model->name = $request->input('name');
            $model->slug = $request->input('slug');
            $model->image = $image;

            $model->save();
            $request->session()->flash('message', 'Cập nhật thương hiệu thành công');
            return redirect('/admin/branches');
        }else{
            return redirect('/admin/branches');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Branch  $branch
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $model = Branch::find($id);
        if($model){
            unlink('storage/images/branches/'.$model->image);
            $model->delete();
            $request->session()->flash('message', 'Xóa thương hiệu thành công');
            return redirect('/admin/branches');
        }else{
            return redirect('/admin/branches');
        }
    }
}
