@extends('admin.main')

@section('content')
    <h2 class="heading">
        <i class="fa-solid fa-users"></i>
        Users Management
    </h2>
    <div class="search">
        <input type="text" name="keyword" placeholder="Nhập tên người dùng" class="search-input">
        <a id="search-btn" class="search-icon-link">
            <i class="fa-solid fa-magnifying-glass"></i>
        </a>

        <select name="level" class="filter-level" id="level">
            <option value="0">Tất cả</option>
            <option value="1">Người dùng</option>
            <option value="2">Nhân viên</option>
            <option value="3">Quản trị viên</option>
        </select>
    </div>

    <div class="users">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>{{$user->id}}</td>
                        <td>{{$user->name}}</td>
                        <td>{{$user->email}}</td>
                        <td>{{$user->phone}}</td>
                        <td>{{$user->address}}</td>
                        <td>
                            <a href="/admin/users/edit/{{$user->id}}" class="edit-link">
                                <i class="fa-solid fa-pen"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        const searchBtn = document.getElementById('search-btn');
        searchBtn.onclick = e => {
            const keyword = document.querySelector('input[name=keyword]').value;
            const level = document.getElementById('level').value;
            location.href = `/admin/users?search=${keyword}&level=${level}`;
        }
    </script>

    @if (Session::has('update'))
        <x-alert type="success" text="{{Session::get('update')}}" />
    @endif
@endsection

@section('head')
    @vite(['resources/scss/admin/users/users.scss', 'resources/scss/components/alert.scss'])
@endsection
