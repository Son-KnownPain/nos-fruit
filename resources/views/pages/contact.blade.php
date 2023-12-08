@extends('layouts.main')

@section('content')
    <div class="container">
        <h1 class="heading">
            Liên hệ với chúng tôi
        </h1>

        <div class="row">
            <div class="col-xl-6">
                <div class="conntact-info contact-box">
                    <h3 class="title">
                        Thông tin liên hệ
                    </h3>
                    <div class="info-item">
                        <h4 class="item-name">
                            <i class="fa-solid fa-phone item-icon"></i>
                            Hotline tư vấn 24/24
                        </h4>
                        <a href="tel:01216855741" class="item-value">01216855741</a>
                    </div>
                    <div class="info-item">
                        <h4 class="item-name">
                            <i class="fa-solid fa-envelope item-icon"></i>
                            Email
                        </h4>
                        <a href="mailto:sonhong443@gmail.com" class="item-value">sonhong443@gmail.com</a>
                    </div>
                    <div class="info-item">
                        <h4 class="item-name">
                            <i class="fa-solid fa-map-location-dot item-icon"></i>
                            Địa chỉ
                        </h4>
                        <a class="item-value">Tầng 4 - Tòa nhà Hanoi Group - 442 Đội Cấn - Ba Đình - Hà Nội</a>
                    </div>
                </div>
            </div>
            <div class="col-xl-6">
                <div class="contact-form contact-box">
                    <h3 class="title">
                        Gửi liên hệ
                    </h3>
                    <form action="/contact/send" method="POST" id="contact-form">
                        @csrf
                        {{-- **** --}}
                        <div class="mb-3 form-group">
                            <label for="name" class="form-label">
                                Họ tên
                                <span class="asterisk">
                                    *
                                </span>
                            </label>
                            <input type="text" class="form-control" id="name" name="name">
                            <span class="err-msg"></span>
                        </div>
                        {{-- **** --}}
                        <div class="mb-3 form-group">
                            <label for="email" class="form-label">
                                Địa chỉ email
                                <span class="asterisk">
                                    *
                                </span>
                            </label>
                            <input type="email" class="form-control" id="email" name="email">
                            <span class="err-msg"></span>
                        </div>
                        {{-- **** --}}
                        <div class="mb-3 form-group">
                            <label for="message" class="form-label">
                                Lời nhắn
                            </label>
                            <textarea id="message" cols="30" rows="5" name="message"></textarea>
                            <span class="err-msg"></span>
                        </div>
                        <button type="submit">Gửi</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @if (Session::has('submit'))
        <x-alert type="success" text="{{Session::get('submit')}}" />
    @endif
@endsection

@section('head')
    @vite(['resources/scss/contact.scss', 'resources/scss/components/alert.scss'])
@endsection

@section('script')
    <script src="/js/validator.js"></script>
    <script>
        Validator({
            form: '#contact-form',
            formGroup: '.form-group',
            errorSelector: '.err-msg',
            rules: [
                Validator.isRequired('#name', 'Vui lòng nhập họ và tên'),
                Validator.isRequired('#email', 'Vui lòng nhập email'),
                Validator.isEmail('#email', 'Định dạng email không chính xác')
            ],
            onSubmit: function(data) {
                document.getElementById('contact-form').submit()
            }
        });
    </script>
@endsection