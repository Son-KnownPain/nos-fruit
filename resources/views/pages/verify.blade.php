@extends('layouts.main')

@section('content')
<div class="container">
    <div class="register-box">
        <h3 class="page-heading">
            Xác thực email
        </h3>

        <p class="text">
            Vui lòng xác thực email
        </p>

        <div class="input-box">
            <form id="account-form" action="/email/verification-notification" method="POST">
                @csrf
                <button type="submit" class="submit-btn">Gửi lại mã xác thực</button>
            </form>
        </div>
    </div>
</div>
@endsection

@section('head')
    @vite(['resources/scss/verify.scss'])
@endsection