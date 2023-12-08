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
    <h3 class="heading">Thêm danh mục mới</h3>
    <form action="/admin/categories/add/store" method="POST" id="category-form">
        @csrf
        <label for="name">Tên danh mục</label>
        <input type="text" name="name" id="name" autofocus>

        <button>Thêm</button>
    </form>
@endsection

@section('head')
    @vite(['resources/scss/admin/categories/form.scss'])
@endsection