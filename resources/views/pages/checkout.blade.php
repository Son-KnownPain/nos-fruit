@extends('layouts.main')

@section('content')
    <div class="container">
        <h2 class="page-heading">Tiến hành đặt hàng</h2>
        <div class="mt-5 order-box">
            @if (Session::has('cart'))
                <div class="row">
                    <div class="col-xl-6">
                        <div class="products-review">
                            @php
                                $sum = 0;
                                $totalQuantity = 0;
                            @endphp
                            @foreach (Session::get('cart') as $product)
                                @php
                                    $sum += ($product['price'] - ($product['price'] * $product['discount'])) * $product['quantity'];
                                    $totalQuantity += 1;
                                @endphp
                                <div class="row item-review">
                                    <div class="col-xl-3">
                                        <img src="/images/products/{{ $product['thumbnail'] }}" alt="Hình ảnh sản phẩm" class="thumbnail">
                                    </div>
                                    <div class="col-xl-9">
                                        <h4 class="name">
                                            {{ $product['name'] }}
                                        </h4>
                                        <p class="unit-price">Đơn giá: <span>{{ App\Helper::moneyFormat( $product['price'] - ($product['price'] * $product['discount']) ) }} VNĐ</span></p>
                                        <p class="quantity">Số lượng: <span>{{ $product['quantity'] }}</span></p>
                                        <p class="final-price">Thành tiền: <span>{{ App\Helper::moneyFormat( ($product['price'] - ($product['price'] * $product['discount'])) * $product['quantity'] ) }} VNĐ</span></p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="col-xl-6">
                        <div class="payment-info">
                            <h3 class="title">Sơ lược thông tin thanh toán</h3>

                            <p class="note"><span class="highlight">Lưu ý:</span> vui lòng <a href="/profile#edit-address">chỉnh sửa địa chỉ nhận hàng ở trang cá nhân</a> và điền thông tin cần thiết để việc giao hàng trở nên nhanh chóng!</p>

                            <p class="key">Số lượng sản phẩm: <span class="value">{{ $totalQuantity }}</span></p>

                            <p class="key">Cần thanh toán: <span class="value">{{ App\Helper::moneyFormat($sum) }} VNĐ</span></p>

                            <p class="key">Hình thức thanh toán: <span class="value">Thanh toán khi nhận hàng</span></p>

                            <p class="key">Địa chỉ nhận hàng: <span class="value">{{ Auth::user()->address }}</span></p>

                            <form action="/checkout/confirm" method="POST">
                                @csrf

                                <label class="label" for="#entered_address">Địa chỉ chi tiết hơn</label>
                                <input class="input" name="entered_address" type="text" id="entered_address">

                                <label class="label" for="#phone">Số điện thoại</label>
                                <input class="input" name="phone" type="text" id="phone" value="{{ Auth::user()->phone }}">

                                <label class="label" for="note">Ghi chú</label>
                                <textarea class="input" name="note" id="#note" cols="30" rows="8">Ghi chú gửi đến nhà bán hàng!</textarea>

                                <button>Xác nhận đặt hàng</button>
                            </form>
                        </div>
                    </div>
                </div>
            @else
                <h2 style="text-align: center; font-size: 2rem">Không có sản phẩm để thanh toán. <a href="/">Quay về trang chủ</a></h2>
            @endif
        </div>
    </div>

    @if ($errors->any())
        @foreach ($errors->all() as $error)
            <x-alert type="error" text="{{$error}}"/>
        @endforeach
    @endif
@endsection

@section('head')
    @vite(['resources/scss/checkout.scss', 'resources/scss/components/alert.scss'])
@endsection

@section('script')
    
@endsection