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
    
    <h3 class="heading">Thêm sản phẩm mới</h3>
    <form action="/admin/products/add/store" method="POST" id="product-form" enctype="multipart/form-data">
        @csrf

        <label for="cateogory">Chọn danh mục</label>
        <select name="category_id" id="category">
            @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->name }}</option>
            @endforeach
        </select>

        <label for="name">Tên sản phẩm</label>
        <input type="text" name="name" id="name">
        
        <label for="price">Giá</label>
        <input type="number" name="price" id="price">
        
        <label for="quantity">Số lượng</label>
        <input type="number" name="quantity" id="quantity" value="0">

        <label for="discount">Chiết khấu</label>
        <input type="number" name="discount" id="discount">

        <label for="summary">Sơ lược về sản phẩm</label>
        <textarea name="summary" id="summary" cols="30" rows="3"></textarea>

        <label for="thumbnail">Ảnh sản phẩm</label>
        <input type="file" name="thumbnail" id="thumbnail" accept="image/*">

        <label for="editor">Mô tả sản phẩm</label>
        <textarea type="text" id="editor" name="description"></textarea>

        <button>Thêm</button>
    </form>
@endsection

@section('head')
    @vite(['resources/scss/admin/products/form.scss'])
@endsection

@section('script')
    <script src="//cdn.ckeditor.com/4.20.1/standard/ckeditor.js"></script>

    <script>
        CKEDITOR.replace( 'editor' );
    </script>
@endsection