@extends('admin.main')

@section('content')
    <form action="/admin/users/{{$user->id}}/update" class="edit-form" id="edit-form">
        @csrf
        <div class="mb-3 form-group">
            <label for="name" class="form-label">
                Họ và tên
                <span class="asterisk">
                    *
                </span>
            </label>
            <input value="{{ $user->name }}" name="name" type="text" class="form-input" id="name">
            <span class="err-msg"></span>
        </div>

        <div class="mb-3 form-group">
            <label for="phone" class="form-label">
                Số điện thoại
                <span class="asterisk">
                    *
                </span>
            </label>
            <input value="{{ $user->phone }}" name="phone" type="text" class="form-input" id="phone">
            <span class="err-msg"></span>
        </div>

        <div class="mb-3 form-group">
            <label for="email" class="form-label">
                Email
                <span class="asterisk">
                    *
                </span>
            </label>
            <input value="{{ $user->email }}" name="email" type="email" class="form-input" id="email">
            <span class="err-msg"></span>
        </div>

        <div class="mb-3 form-group">
            <label for="address" class="form-label">
                Địa chỉ
                <span class="asterisk">
                    *
                </span>
            </label>
            <input value="{{ $user->address }}" name="address" type="text" class="form-input" id="address">
            <span class="err-msg"></span>
        </div>

        <button type="submit" class="submit-btn">Chỉnh sửa</button>
    </form>
@endsection

@section('head')
    @vite(['resources/scss/admin/users/edit.scss'])
@endsection

@section('script')
    <script src="/js/validator.js"></script>
    <script src="/js/eye.js"></script>
    <script>
        Validator({
            form: '#edit-form',
            formGroup: '.form-group',
            errorSelector: '.err-msg',
            rules: [
                Validator.isRequired('#name', 'Vui lòng nhập họ và tên'),
                Validator.isRequired('#phone', 'Vui lòng nhập số điện thoại'),
                Validator.minLength('#phone', 10, 'Vui lòng nhập đủ 10 số'),
                Validator.isRequired('#email', 'Vui lòng nhập email'),
                Validator.isEmail('#email', 'Định dạng email không chính xác'),
                Validator.isRequired('#address', 'Vui lòng nhập địa chỉ'),
            ],
            onSubmit: function(data) {
                const form = document.getElementById('edit-form')
                fetch(form.action, {
                    method: 'PUT',
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify(data)
                }).then(res => res.json())
                .then(res => {
                    if (res.isUpdate) {
                        location.href = '/admin/users'
                    } else {
                        location.reload()
                    }
                });
            }
        });
    </script>
@endsection