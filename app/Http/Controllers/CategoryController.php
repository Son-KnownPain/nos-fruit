<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryController extends Controller
{
    public function categories(Request $request) {
        $categories;

        if ($request->query()['search'] ?? false) {
            $search = $request->query()['search'];

            $categories = Category::where('name', 'LIKE', "%$search%")->get();
        } else {
            $categories = Category::all();
        }

        return view('admin.categories.index', [
            'title' => 'Quản lí danh mục',
            'categories' => $categories
        ]);
    }

    public function add() {
        return view('admin.categories.add', [
            'title' => 'Thêm danh mục mới'
        ]);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'name' => 'required|regex:/^[\pL\s\-]+$/u'
        ]);
        
        $name = $request->input('name');

        Category::create([
            'name' => $name,
            'slug' => Str::slug($name)
        ]);

        return redirect('/admin/categories');
    }

    public function edit(Request $request, $id) {
        $category = Category::findOrFail($id);

        return view('admin.categories.edit', [
            'title' => 'Chỉnh sửa danh mục',
            'category' => $category
        ]);
    }

    public function update(Request $request, $id) {
        $validated = $request->validate([
            'name' => 'required|regex:/^[\pL\s\-]+$/u'
        ]);

        $name = $request->input('name');

        $category = Category::findOrFail($id);

        $category->name = $name;
        $category->slug = Str::slug($name);

        $category->save();

        return redirect('admin/categories');
    }
}
