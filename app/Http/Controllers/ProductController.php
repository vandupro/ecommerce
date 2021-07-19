<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Category;
use App\Models\Cate_Product;
use App\Models\Product;
use App\Models\Tag;
use App\Models\Tag_Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $categories;
    protected $branches;
    protected $tags;

    public function __construct()
    {
        $this->categories = Category::select(['id','slug', 'name'])->get();
        $this->branches = Branch::select(['id', 'slug', 'name'])->get();
        $this->tags = Tag::select(['id', 'slug', 'name'])->get();
    }
    public function index(Request $request)
    {   
        $searchData = $request->except('page');
        $models = Product::where(function ($query) use ($request) {
            if ($request->category) {
                $cate = Category::where('slug', $request->category)->first();
                $items = $cate->cate_products;
                $pro_id = [];
                foreach ($items as $i) {
                    $pro_id[] = $i->product_id;
                }
                return $query->from('products')->whereIn('id', $pro_id);
            }
        })->where(function($query) use($request){
            if ($request->tag) {
                $tag = Tag::where('slug', $request->tag)->first();
                $items = $tag->tag_products;
                $pro_id = [];
                foreach ($items as $i) {
                    $pro_id[] = $i->product_id;
                }
                return $query->from('products')->whereIn('id', $pro_id);
            }
        })->where(function($query) use($request){
            return $request->branch?$query->from('products')->where('branch_id', $request->branch) : '';
        })->where(function($query) use($request){
            return $request->keyword?$query->from('products')->where('name', 'like', "%$request->keyword%"):'';
        })
        ->orderBy('id', 'desc')
            ->paginate(10)->appends($searchData);

        $categories = $this->categories;
        $branches = $this->branches;
        $tags = $this->tags;
        $request->session()->flash('check', ['cate'=> $request->category, 'tag'=>$request->tag, 'branch'=>$request->branch]);
        $param = [
            'tag'=>$request->tag,
            'category'=>$request->category,
            'branch'=>$request->branch,
            'keyword'=>$request->keyword,
        ];
        return view('admin.pages.products.index', 
        compact('models', 'categories', 'branches', 'tags', 'param'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categories;
        $branches = $this->branches;
        $tags = $this->tags;
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
            'name' => 'required|unique:products',
            'slug' => 'required|unique:products',
            'image' => 'required|mimes:jpg,bmp,png',
            'price' => 'required',
            'competitive_price' => 'required',
            'short_desc' => 'required',
        ]);

        if ($request->hasFile('image')) {
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
        if (isset($_POST['cate_id'])) {
            for ($i = 0; $i < count($_POST['cate_id']); $i++) {
                $arr1[] = ['cate_id' => $_POST['cate_id'][$i], 'product_id' => $model->id];
            }
            Cate_Product::insert($arr1);
        }
        if (isset($_POST['cate_id'])) {
            for ($i = 0; $i < count($_POST['tag_id']); $i++) {
                $arr2[] = ['tag_id' => $_POST['tag_id'][$i], 'product_id' => $model->id];
            }
            Tag_Product::insert($arr2);
        }
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

        if ($model) {
            $categories = $this->categories;
            $branches = $this->branches;
            $tags = $this->tags;
            return view('admin.pages.products.edit', compact('model', 'categories', 'branches', 'tags', 'product_ids', 'tag_ids'));
        } else {
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
            'name' => 'required',
            'slug' => 'required',
            'image' => 'mimes:jpg,bmp,png',
            'price' => 'required',
            'competitive_price' => 'required',
            'short_desc' => 'required',
        ]);
        $image = '';
        $model = Product::find($request->product_id);
        if ($request->hasFile('image')) {
            $destinationPath = 'public/images/products';
            $image = $request->file('image');
            $image_name = $image->getClientOriginalName();
            $request->file('image')->storeAs($destinationPath, $image_name);
            $image = $image_name;
            if (file_exists('storage/images/products/' . $model->image)) {
                unlink('storage/images/products/' . $model->image);
            }
        } else {
            $image = $request->input('image2');
        }
        if ($model) {
            $arr1 = [];
            $arr2 = [];
            $model->fill($_POST);
            $model->image = $image;
            $model->save();
            if (isset($_POST['cate_id'])) {
                for ($i = 0; $i < count($_POST['cate_id']); $i++) {
                    $arr1[] = ['cate_id' => $_POST['cate_id'][$i], 'product_id' => $model->id];
                }
                Cate_Product::where('product_id', $model->id)->delete();
                Cate_Product::insert($arr1);
            }

            if (isset($_POST['tag_id'])) {
                for ($i = 0; $i < count($_POST['tag_id']); $i++) {
                    $arr2[] = ['tag_id' => $_POST['tag_id'][$i], 'product_id' => $model->id];
                }
                Tag_Product::where('product_id', $model->id)->delete();
                Tag_Product::insert($arr2);
            }
            $request->session()->flash('message', 'Cập nhật sản phẩm thành công');
            return redirect('/admin/products');
        } else {
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
        if ($model) {
            if (file_exists('storage/images/products/' . $model->image)) {
                unlink('storage/images/products/' . $model->image);
            }
            $model->delete();
            $request->session()->flash('message', 'Xóa sản phẩm thành công');
            return redirect('/admin/products');
        } else {
            return redirect('/admin/products');
        }
    }
}
