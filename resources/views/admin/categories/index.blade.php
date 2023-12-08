@extends('admin.main')

@section('content')
    <h2 class="heading">
        <i class="fa-solid fa-layer-group"></i>
        Categories Management
    </h2>
    <div class="search add">
        <input type="text" name="keyword" placeholder="Nhập tên danh mục" class="search-input" tabindex="2">
        <a id="search-btn" class="search-icon-link" tabindex="3">
            <i class="fa-solid fa-magnifying-glass"></i>
        </a>

        <a href="/admin/categories/add" class="other-btn" tabindex="1">Thêm danh mục mới</a>
    </div>

    <div class="categories">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->slug}}</td>
                        <td>
                            <a href="/admin/categories/edit/{{$category->id}}" class="edit-link">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function handleSeach() {
            const searchKeyword = document.querySelector('input[name=keyword]').value;
            location.href = '/admin/categories?search=' + searchKeyword;
        }
        document.getElementById('search-btn').onclick = e => {
            handleSeach();
        }

        document.getElementById('search-btn').onkeypress = e => {
            handleSeach();
        }

    </script>
@endsection

@section('head')
    @vite(['resources/scss/admin/categories/index.scss'])
@endsection