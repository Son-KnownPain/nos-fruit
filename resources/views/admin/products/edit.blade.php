@extends('admin.main')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h3 class="heading">Chỉnh sửa sản phẩm {{ $product->name }}</h3>
    <form action="/admin/products/edit/{{$product->id}}/update" method="POST" id="product-form" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <label for="cateogory">Chọn danh mục</label>
        <select name="category_id" id="category">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="name">Tên sản phẩm</label>
        <input type="text" name="name" id="name" value="{{ $product->name }}">

        <label for="price">Giá</label>
        <input type="number" name="price" id="price" value="{{ $product->price }}">

        <label for="quantity">Số lượng</label>
        <input type="number" name="quantity" id="quantity" value="0" value="{{ $product->quantity }}">

        <label for="discount">Chiết khấu</label>
        <input type="number" name="discount" id="discount" value="{{ $product->discount * 100 }}">

        <label for="summary">Sơ lược về sản phẩm</label>
        <textarea name="summary" id="summary" cols="30" rows="3">{{ $product->summary }}</textarea>

        <label for="thumbnail">Ảnh sản phẩm</label>
        <input type="file" name="thumbnail" id="thumbnail" accept="image/*">

        <label for="editor">Mô tả sản phẩm</label>
        <textarea type="text" id="editor" name="description">{{ $product->description }}</textarea>

        <button>Lưu</button>
    </form>
@endsection

@section('head')
    @vite(['resources/scss/admin/products/form.scss'])
@endsection

@section('script')
    <script src="//cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace('editor');
    </script>
@endsection
