@extends('layouts.main')

@section('content')
    <div class="container">
        <div class="login-box">
            <h3 class="page-heading">
                Đăng nhập
            </h3>

            <p class="text">
                Nếu bạn đã có tài khoản, vui lòng đăng nhập
            </p>
            <p class="text">
                Trường có đánh dấu sao là bắt buộc
            </p>

            <div class="input-box">
                <form id="account-form">
                    @csrf
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

                    <button class="submit-btn">Đăng nhập</button>
                </form>
            </div>

            <p class="text">
                Bạn chưa có tài khoản? Đăng ký <a href="/register" class="text-link">tại đây</a>
            </p>
        </div>
    </div>

    {{-- Phần cảnh báo --}}
    @if (Session::has('user-wrong'))
        <x-alert type="error" text="{{Session::get('user-wrong')}}" />
    @endif
@endsection

@section('head')
    @vite(['resources/scss/login.scss', 'resources/scss/components/alert.scss'])
@endsection

@section('script')
    <script src="/js/validator.js"></script>
    <script src="/js/eye.js"></script>
    <script>
        Validator({
            form: '#account-form',
            formGroup: '.form-group',
            errorSelector: '.err-msg',
            rules: [
                Validator.isRequired('#email', 'Vui lòng nhập email'),
                Validator.isEmail('#email', 'Định dạng email không chính xác'),
                Validator.minLength('#password', 6, 'Mật khẩu phải có ít nhất 6 kí tự')
            ],
            onSubmit: function(data) {
                fetch('/login/store', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json, text/plain, */*',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify(data)
                    }).then(res => res.json())
                    .then(res => {
                        if (res.isLogin) {
                            location.href = '/profile'
                        } else {
                            location.reload()
                        }
                    });
            }
        });
    </script>
@endsection
