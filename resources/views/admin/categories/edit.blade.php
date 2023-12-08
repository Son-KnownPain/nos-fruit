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
    <h3 class="heading">Chỉnh sửa danh mục {{ $category->name }}</h3>
    <form action="/admin/categories/edit/{{ $category->id }}/update" method="POST" id="category-form">
        @csrf
        @method('PUT')

        <label for="name">Tên danh mục</label>
        <input type="text" name="name" id="name" value="{{ $category->name }}" autofocus>

        <button>Sửa</button>
    </form>
@endsection

@section('head')
    @vite('resources/scss/admin/categories/form.scss')
@endsection