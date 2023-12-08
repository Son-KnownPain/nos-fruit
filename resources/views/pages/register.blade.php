@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="register-box">
            <h3 class="page-heading">
                Đăng ký
            </h3>

            <p class="text">
                Vui lòng nhập các thông tin của bạn
            </p>
            <p class="text">
                Trường có đánh dấu sao là bắt buộc
            </p>

            <div class="input-box">
                <form id="account-form">
                    @csrf
                    <div class="mb-3 form-group">
                        <label for="name" class="form-label">
                            Họ và tên
                            <span class="asterisk">
                                *
                            </span>
                        </label>
                        <input name="name" type="text" class="form-input" id="name">
                        <span class="err-msg"></span>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="phone" class="form-label">
                            Số điện thoại
                            <span class="asterisk">
                                *
                            </span>
                        </label>
                        <input name="phone" type="text" class="form-input" id="phone">
                        <span class="err-msg"></span>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="email" class="form-label">
                            Email
                            <span class="asterisk">
                                *
                            </span>
                        </label>
                        <input name="email" type="email" class="form-input" id="email">
                        <span class="err-msg"></span>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="password" class="form-label">
                            Mật khẩu
                            <span class="asterisk">
                                *
                            </span>
                        </label>
                        <div class="pass-box">
                            <input name="password" type="password" class="form-input" id="password">
                            <i class="fa-solid fa-eye eye" data-for="#password"></i>
                        </div>
                        <span class="err-msg"></span>
                    </div>

                    <div class="mb-3 form-group">
                        <label for="password-confirm" class="form-label">
                            Nhập lại mật khẩu
                            <span class="asterisk">
                                *
                            </span>
                        </label>
                        <div class="pass-box">
                            <input name="password_confirm" type="password" class="form-input" id="password-confirm">
                            <i class="fa-solid fa-eye eye" data-for="#password-confirm"></i>
                        </div>
                        <span class="err-msg"></span>
                    </div>

                    <button type="submit" class="submit-btn">Đăng ký</button>
                </form>
            </div>

            <p class="text">
                Bạn đã có tài khoản? Đăng nhập <a href="/login" class="text-link">tại đây</a>
            </p>
        </div>
    </div>

    {{-- Thư viện --}}
    <div id="loader"></div>
    <div id="toast"></div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <x-alert type="error" text="{{ $error }}" />
        @endforeach
    @endif
@endsection

@section('head')
    @vite(['resources/scss/register.scss', 'resources/scss/components/alert.scss'])
    <link rel="stylesheet" href="/libraries/messages/messages.css">
    <link rel="stylesheet" href="/libraries/loading/loading.css">
@endsection

@section('script')
    <script src="/libraries/messages/messages.js"></script>
    <script src="/libraries/loading/loading.js"></script>
    <script src="/js/validator.js"></script>
    <script src="/js/eye.js"></script>
    <script>
        Validator({
            form: '#account-form',
            formGroup: '.form-group',
            errorSelector: '.err-msg',
            rules: [
                Validator.isRequired('#name', 'Vui lòng nhập họ và tên'),
                Validator.isRequired('#phone', 'Vui lòng nhập số điện thoại'),
                Validator.minLength('#phone', 10, 'Vui lòng nhập đủ 10 số'),
                Validator.isRequired('#email', 'Vui lòng nhập email'),
                Validator.isEmail('#email', 'Định dạng email không chính xác'),
                Validator.minLength('#password', 6, 'Mật khẩu phải có ít nhất 6 kí tự'),
                Validator.isRequired('#password-confirm', 'Vui lòng nhập lại mật khẩu'),
                Validator.isConfirmed('#password-confirm', function() {
                    return document.getElementById('password').value
                }, 'Mật khẩu nhập lại không khớp')
            ],
            onSubmit: function(data) {
                myLoader(true);
                fetch('/register/store', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json, text/plain, */*',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    }).then(res => res.json())
                    .then(res => {
                        myLoader(false);
                        if (res.isCreate) {
                            location.href = '/profile'
                        } else {
                            toast({
                                title: 'Dữ liệu không hợp lệ',
                                message: res.message || 'Dữ liệu bạn nhập vào chưa hợp lệ',
                                type: 'error',
                                duration: 6000
                            });
                        }
                    });
            }
        });
    </script>
@endsection
