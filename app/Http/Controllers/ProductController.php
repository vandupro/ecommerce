<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Cate_Product;
use App\Models\Category;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Tag_Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $models = Product::all();

        return view('admin.pages.products.index', compact('models'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {   
        $categories = Category::all();
        $branches = Branch::all();
        $tags = Tag::all();
        return view('admin.pages.products.create', compact('categories', 'branches', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $model = new Product();
        $request->validate([
            'name'=>'required|unique:products',
            'slug'=>'required|unique:products',
            'image'=>'required|mimes:jpg,bmp,png',
            'price'=>'required',
            'competitive_price'=>'required',
            'short_desc'=>'required'
        ]);
        
        if($request->hasFile('image')){
            $destinationPath = 'public/images/products';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $request->file('image')->storeAs($destinationPath, $image_name);
            $request->image = $image_name;
        }
        $arr1 = [];
        $arr2 = [];
        $model->fill($_POST);
        $model->image = $request->image;
        $model->save();
        for($i = 0; $i < count($_POST['cate_id']); $i++){
            $arr1[] = ['cate_id'=>$_POST['cate_id'][$i], 'product_id'=>$model->id];
        }
        for($i = 0; $i < count($_POST['tag_id']); $i++){
            $arr2[] = ['tag_id'=>$_POST['tag_id'][$i], 'product_id'=>$model->id];
        }
        Cate_Product::insert($arr1);
        Tag_Product::insert($arr2);
        $request->session()->flash('message', 'Thêm sản phẩm thành công');
        return redirect('/admin/products');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
    {
        $model = Product::find($id);
        $product_ids = $model->product_cate_pros;
        $tag_ids = $model->product_tags;

        if($model){
            $categories = Category::all();
            $branches = Branch::all();
            $tags = Tag::all();
            return view('admin.pages.products.edit', compact('model', 'categories', 'branches', 'tags','product_ids', 'tag_ids'));
        }else{
            return redirect('/admin/products');
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'slug'=>'required',
            'image'=>'mimes:jpg,bmp,png',
            'price'=>'required',
            'competitive_price'=>'required',
            'short_desc'=>'required'
        ]);
        $image = '';
        $model = Product::find($request->product_id);
        if($request->hasFile('image')){
            $destinationPath = 'public/images/products';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $request->file('image')->storeAs($destinationPath, $image_name);
            $image = $image_name;
            if(file_exists('storage/images/products/'.$model->image)){
                unlink('storage/images/products/'.$model->image);
            }
        } else {
            $image = $request->input('image2');
        }
        if($model){
            $arr1 = [];
            $arr2 = [];
            $model->fill($_POST);
            $model->image = $image;
            $model->save();
            for($i = 0; $i < count($_POST['cate_id']); $i++){
                $arr1[] = ['cate_id'=>$_POST['cate_id'][$i], 'product_id'=>$model->id];
            }
            for($i = 0; $i < count($_POST['tag_id']); $i++){
                $arr2[] = ['tag_id'=>$_POST['tag_id'][$i], 'product_id'=>$model->id];
            }
            Cate_Product::where('product_id', $model->id)->delete();
            Cate_Product::insert($arr1);

            Tag_Product::where('product_id', $model->id)->delete();
            Tag_Product::insert($arr2);
            $request->session()->flash('message', 'Cập nhật sản phẩm thành công');
            return redirect('/admin/products');
        }else{
            return redirect('/admin/products');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $model = Product::find($id);
        if($model){
            if(file_exists('storage/images/products/'.$model->image)){
                unlink('storage/images/products/'.$model->image);
            }
            $model->delete();
            $request->session()->flash('message', 'Xóa sản phẩm thành công');
            return redirect('/admin/products');
        }else{
            return redirect('/admin/products');
        }
    }
}
