@extends('admin.main')

@section('content')
    <h2 class="heading">
        <i class="fa-solid fa-envelope"></i>
        User Contacts Management
    </h2>

    <div class="search add">
        <input type="text" name="keyword" placeholder="Nhập tên người liên hệ" class="search-input" tabindex="1">
        <a id="search-btn" class="search-icon-link" tabindex="2">
            <i class="fa-solid fa-magnifying-glass"></i>
        </a>
    </div>

    <div class="products">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Contact Name</th>
                    <th>Email</th>
                    <th>Message</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($contacts as $contact)
                    <tr>
                        <td>{{$contact->id}}</td>
                        <td>{{$contact->contact_name}}</td>
                        <td>
                            <a style="color: #333" href="mailto:{{$contact->email}}" title="Gửi mail ngay">{{$contact->email}}</a>
                        </td>
                        <td style="max-width: 500px">{{$contact->message}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        function handleSeach() {
            const searchKeyword = document.querySelector('input[name=keyword]').value;
            location.href = '/admin/contacts?search=' + searchKeyword;
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
    @vite(['resources/scss/admin/contacts/index.scss'])
@endsection