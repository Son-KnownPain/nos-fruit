<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    public function products(Request $request) {
        $products;

        if ((($request->query()['search'] ?? false) || ($request->query()['search'] ?? false) == null) && isset($request->query()['status']) && isset($request->query()['cid'])) {
            $search = $request->query()['search'];
            $status = $request->query()['status'];
            $category_id = $request->query()['cid'];

            $products = Product::where('name', 'LIKE', "%$search%");

            if ($status != 'all') {
                switch ($status) {
                    case 'yes':
                        $products = $products->where('quantity', '>', 0);
                        break;
                    case 'no':
                        $products = $products->where('quantity', '=', 0);
                        break;
                    default:
                        # code...
                        break;
                }
            }

            if ($category_id != '0') {
                $products = $products->where('category_id', '=', $category_id);
            }

            $products = $products->get();
        } else {
            $products = Product::all();
        }

        return view('admin.products.index', [
            'title' => 'Quản lí sản phẩm',
            'products' => $products,
            'categories' => Category::all(),
        ]);
    }

    public function add() {
        $categories = Category::all();

        return view('admin.products.add', [
            'title' => 'Thêm sản phẩm mới',
            'categories' => $categories
        ]);
    }

    public function store(Request $request) {
        // return response()->json($request->input());
        $validated = $request->validate([
            'category_id' => 'required|numeric|min:0|not_in:0',
            'name' => 'required',
            'price' => 'required|numeric|min:0|not_in:0',
            'quantity' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0|max:100',
            'summary' => 'required|max:1000',
            'thumbnail' => 'required|max:2048',
            'description' => 'required|max:4000',
        ]);

        $data = $request->input();

        if (!Category::where('id', '=', $data['category_id'])->exists()) {
            return redirect()->back();
        }

        $imgName = 'img'.time().'-'.Str::slug($data['name']).'.'.$request->file('thumbnail')->extension();

        $request->file('thumbnail')->move(public_path('images\products'), $imgName);

        $product = new Product;

        $product->category_id = intval($data['category_id']);
        $product->name = $data['name'];
        $product->price = intval($data['price']);
        $product->quantity = intval($data['quantity']);
        $product->discount = floatval(intval($data['discount']) / 100);
        $product->summary = $data['summary'];
        $product->thumbnail = $imgName;
        $product->description = $data['description'];

        $product->save();

        $request->session()->flash('create', 'Thêm sản phẩm thành công');

        return redirect('/admin/products');
    }

    public function edit(Request $request, $id) {
        $product  = Product::where('id', '=', $id)->get();

        return view('admin.products.edit', [
            'title' => 'Chỉnh sửa sản phẩm',
            'product' => $product->first(),
            'categories' => Category::all(),
        ]);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'category_id' => 'required|numeric|min:0|not_in:0',
            'name' => 'required',
            'price' => 'required|numeric|min:0|not_in:0',
            'quantity' => 'required|numeric|min:0',
            'discount' => 'required|numeric|min:0|max:100',
            'summary' => 'required|max:1000',
            'thumbnail' => 'max:2048',
            'description' => 'required|max:4000',
        ]);

        $data = $request->input();

        if (!Category::where('id', '=', $data['category_id'])->exists()) {
            return redirect()->back();
        }

        $productBeUpdate = Product::findOrFail($id);

        $productBeUpdate->category_id = intval($data['category_id']);
        $productBeUpdate->name = $data['name'];
        $productBeUpdate->price = intval($data['price']);
        $productBeUpdate->quantity = intval($data['quantity']);
        $productBeUpdate->discount = floatval(intval($data['discount']) / 100);
        $productBeUpdate->summary = $data['summary'];
        // Kiểm tra nếu có upload file ảnh mới thì mới sửa db
        if ($request->hasFile('thumbnail')) {
            $imgName = 'img'.time().'-'.Str::slug($data['name']).'.'.$request->file('thumbnail')->extension();
            $request->file('thumbnail')->move(public_path('images\products'), $imgName);
            $productBeUpdate->thumbnail = $imgName;
        }
        $productBeUpdate->description = $data['description'];

        $productBeUpdate->save();

        $request->session()->flash('update', 'Chỉnh sửa sản phẩm thành công');

        return redirect('/admin/products');
    }
}
