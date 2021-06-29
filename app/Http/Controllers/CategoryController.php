<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     * 
     */
    private $category;
    public function __construct(Category $category)
    {
        $this->category = $category;
    }
    public function index()
    {
        $categorys = $this->category->paginate(10);
        $categorys->load('product');     
        return view("admin.pages.categorys.index", compact('categorys'));
    }

    public function create()
    {
        return view('admin.pages.categorys.create');
    }


    public function store(Request $request)
    {
        // validator
        $rules = [
            'name' => 'required|max:100|min:4',
            'slug' => 'required|max:100|min:4',
        ];
        $messages = [
            'name.required' => 'Mời nhập tên danh mục!',
            'slug.required' => 'Mời nhập slug!',
            'name.max' => 'Tên danh mục không quá 100 ký tự!',
            'slug.max' => 'Slug không quá 100 ký tự!',
            'name.min' => 'Tên danh mục ít nhất 4 ký tự!',
            'slug.min' => 'Slug ít nhất 4 ký tự!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->route('admin.cate.create')
                ->withErrors($validator)
                ->withInput();
        }
        //end validator
        $this->category->create([
            'name' => $request->name,
            'slug' => $request->slug
        ]);
        return \redirect()->route('admin.cate.index')->with('status', 'cập nhật danh mục thành công !');
    }

    public function edit($id,Category $category )
    {
        $categorys = $this->category->find($id);    
        return view('admin.pages.categorys.edit', compact('categorys'));
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required|max:100|min:4',
            'slug' => 'required|max:100|min:4',
        ];
        $messages = [
            'name.required' => 'Mời nhập tên danh mục!',
            'slug.required' => 'Mời nhập slug!',
            'name.max' => 'Tên danh mục không quá 100 ký tự!',
            'slug.max' => 'Slug không quá 100 ký tự!',
            'name.min' => 'Tên danh mục ít nhất 4 ký tự!',
            'slug.min' => 'Slug ít nhất 4 ký tự!',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $this->category->find($id)->update([
            'name' => $request->name,
            'slug' => $request->slug
        ]);
        return redirect()->back()->with('status', 'cập nhật danh mục thành công !');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->category->find($id)->delete();
        return redirect()->back()->with('status', 'xóa danh mục thành công !');
    }
}
