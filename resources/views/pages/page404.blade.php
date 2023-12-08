@extends('layouts.main')

@section('content')
    <div class="container">
        <h1 class="num">
            404
        </h1>
        <h1 class="num">
            Error
        </h1>
        
        <h1 class="message">
            Không tìm thấy trang này
            <i class="fa-regular fa-face-sad-tear"></i>
        </h1>
        <h1 class="message">
            Bạn nên kiểm tra lại đường dẫn!
        </h1>
    </div>
@endsection

@section('head')
    @vite(['resources/scss/page404.scss'])
@endsection
