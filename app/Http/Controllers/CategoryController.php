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
    public function index()
    {
        $models = Category::orderBy('id', 'desc')->get();
        dd($models);
        return view('admin.pages.categories.index', compact('models'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required|unique:categories',
            'slug'=>'required|unique:categories',
        ]);
        //var_dump($request);die;
        $model = new Category();
        $model->name = $request->input('name');
        $model->slug = $request->input('slug');
        $model->save();

        return response()->json($model);
    }

    public function edit( $id )
    {
        $model = Category::find($id);
        return response()->json($model);
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'slug'=>'required',
        ]);

        $model = Category::find($request->id);
        if($model){
            $model->name = $request->name;
            $model->slug = $request->slug;
            $model->save();

            return response()->json($model);
        }else{
            return redirect('/admin/categories');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Category::find($id);
        if($model){
            $model->delete();
            return response()->json($model);
        }else{
            return redirect("/admin/categories");
        }
    }
}
